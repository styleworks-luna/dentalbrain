<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Models\Payments\TossPayment;
use App\Payments\TossPayments\TossPaymentsService;
use App\Payments\TossPayments\TossPaymentsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function success(Request $request)
    {
        $v = Validator::make($request->all(), [
            'amount' => Rule::in(array_values(Membership::$PriceMap)),
            'days' => Rule::in(array_keys(Membership::$PriceMap))
        ], [
            'in' => '잘못된 결제값입니다.'
        ]);

        if ($v->fails()) {
            Log::error("MEMBERSHIP SUCCESS validation failed", [$request->all()]);
            return redirect()->back()->with('alert', $v->errors()->first());
        }

        try {
            DB::beginTransaction();

            $days = $v->validated()['days'];

            $toss = new TossPaymentsService($request->get('paymentKey'));
            $response = $toss->success($request->get('orderId'), $request->get('amount'));

            if ($response === false) {
                // general error
                return redirect()->back()->with(['alert' => '오류가 발생했습니다.']);
            }

            // 멤버십 & 결제정보 생성
            $payment = TossPayment::createByTossSuccess($response);
            $membership = Membership::createWhenTossSuccess($response, $payment, $days);

            // 메일

            DB::commit();
        } catch (TossPaymentsException $exception) {
            DB::rollBack();
            return $exception->render($request);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('MEMBERSHIP TOSS SUCCESS ERROR', [$exception]);
            return redirect()->back()->with('alert');
        }

        // 결과쪽으로 리다이렉트.
        return redirect()->route('membership.paymentResult');
    }

    public function anotherPay(Request $request)
    {
        $v = Validator::make($request->all(), [
            'days' => Rule::in(array_keys(Membership::$PriceMap))
        ], [
            'in' => '잘못된 값입니다.'
        ]);

        if ($v->fails()) {
            return redirect()->back()->with('alert', $v->errors()->first());
        }
        try {
            DB::beginTransaction();

            // 멤버십 & 결제정보 생성
            $payment = TossPayment::createWhenMembershipAnotherPay($request->get('days'));
            $membership = Membership::createWhenAnotherPay($payment, $request->get('days'));

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('MEMBERSHIP ANOTHER PAY ERROR', [$exception]);
            return redirect()->back()->with('alert', '결제 도중 오류가 발생했습니다.');
        }

        // 결과쪽으로 리다이렉트.
        return redirect()->route('membership.paymentResult');
    }
}
