<?php

namespace App\Http\Controllers\Lecture;

use App\Exceptions\TossPaymentsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\SuccessPayments;
use App\Mail\ApplyLecture;
use App\Models\Payments\TossPayment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\Survey;
use App\Services\Payment\TossPaymentsService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class PaymentsController extends Controller
{
    /**
     * 결제 승인 플로우.
     *
     * @param SuccessPayments $request
     * @param Program $program
     * @return RedirectResponse
     */
    public function success(SuccessPayments $request, Program $program)
    {
        $realPrice = $program->getUserSpecificPrice();

        if ($realPrice != $request->get('amount')) {
            return redirect()->back()->with(['alert' => '결제 금액이 맞지 않습니다.', 'fromApply' => true]);
        }

        try {
            DB::beginTransaction();

            $toss = new TossPaymentsService($request->get('paymentKey'));
            $response = $toss->success($request->get('orderId'), $request->get('amount'));

            if ($response === false) {
                return redirect()->back()->with(['alert' => '오류가 발생했습니다.', 'fromApply' => true]);
            }

            $payment = TossPayment::createByTossSuccess($response);

            $programStudent = ProgramStudent::updateWhenTossSuccess($response, $program, $payment);

            Mail::to(Auth::user()->email)->send(new ApplyLecture(Auth::user(), $programStudent));
            Mail::to(config('mail.admin_emails', ['dentalbrainon@gmail.com']))->send(new ApplyLecture(Auth::user(), $programStudent));

            DB::commit();
        } catch (TossPaymentsException $exception) {
            DB::rollBack();
            session()->flash('fromApply', true);

            return $exception->render($request);
        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error('PROGRAM TOSS SUCCESS ERROR', [$exception]);
            return redirect()->back()->with(['alert' => '오류가 발생했습니다.', 'fromApply' => true]);
        }

        return redirect()->route('lectures.result', $program->id);
    }

    /**
     *  신청 이후 결제 양식 보여줌.
     *
     * @param Request $request
     * @param Program $program
     * @return Application|Factory|View|void
     */
    public function showPaymentForm(Request $request, Program $program)
    {
        if (!$request->session()->get('fromApply', false)) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        $surveys = Survey::result($program->id)->get();

        $price = $program->getUserSpecificPrice();

        // 새로고침 가능 하게끔.
        session()->flash('fromApply', true);

        return view(viewPrefix() . 'pages.lecture.lecture_payment', [
            'program' => $program,
            'surveys' => $surveys,
            'price' => $price,
        ]);
    }

    /**
     * 토스에서 가상계좌 입금이 완료 콜백.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deposited(Request $request)
    {
        $v = Validator::make($request->all(), [
            'secret' => ['required', 'string'],
            'status' => ['required', Rule::in(['DONE', 'CANCELED'])],
            'orderId' => ['required', 'string'],
        ]);

        if ($v->fails()) {
            return response()->json(['code' => 0], 500);
        }
        $body = $v->validated();

        try {
            DB::beginTransaction();
            if (env('APP_ENV') == 'production') {
                $payment = TossPayment::query()
                    ->where('secret', 'LIKE', $body['secret'])
                    ->where('orderId', 'LIKE', $body['orderId'])
                    ->first();
            } else {
                $payment = TossPayment::query()
                    ->where('orderId', 'LIKE', $body['orderId'])
                    ->first();
            }
            if ($payment == null) {
                Log::error('DEPOSIT ERROR', [encrypt($request->all())]);

                DB::rollBack();
                return response()->json(['code' => 3], ResponseCode::HTTP_BAD_REQUEST);
            }

            $payment->update([
                'status' => $body['status'],
                'approvedAt' => now(),
            ]);

            $program = $payment->student->program;

            $payment->student()->update([
                'payment_id' => $payment->id,
                'expired_at' => $program->is_online ? now()->addDays($program->term) : $program->place->ended_at,
                'pay_status' => ProgramStudent::$PAY_PAID,
            ]);

            DB::commit();
            return response()->json(['code' => 1], ResponseCode::HTTP_OK);

        } catch (\Exception $e) {
            Log::error('DEPOSIT ERROR', [encrypt($request->all())]);

            DB::rollBack();
            return response()->json(['code' => 2], ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
