<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Models\Payments\Payment;
use App\Payments\TossPayments\TossPayments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MembershipController extends Controller
{
    public function showMembershipDescForm(Request $request)
    {
        return view(viewPrefix() . "pages.membership.membership");
    }

    public function apply(Request $request)
    {
        $v = Validator::make($request->all(), [
            'days' => ['nullable', Rule::in(30, 100)]
        ]);

        if ($v->fails()) {
            return redirect('/')->with('alert', '잘못된 접근입니다.');
        }

        $days = $request->get('days', 30);

        return view(viewPrefix() . "pages.membership.membership_payment", ['days' => $days]);
    }

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

        $days = $v->validated()['days'];

        $toss = new TossPayments($request->get('paymentKey'));
        $response = $toss->success($request->get('orderId'), $request->get('amount'));

        if ($response === false) {
            return redirect()->back()->with(['alert' => '오류가 발생했습니다.', 'fromApply' => true]);
        }

        // 멤버십 & 결제정보 생성
        $payment = Payment::createByTossSuccess($response);
        $membership = Membership::createWhenTossSuccess($response, $payment, $days);

        // 메일

        // 결과쪽으로 리다이렉트.
        return $this->result();
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

        // 멤버십 & 결제정보 생성
        $payment = Payment::createWhenMembershipAnotherPay($request->get('days'));
        $membership = Membership::createWhenAnotherPay($payment, $request->get('days'));

        // 결과쪽으로 리다이렉트.
        return $this->result();
    }

    public function result()
    {
        return view(viewPrefix() . "pages.membership.membership_result");
    }
}
