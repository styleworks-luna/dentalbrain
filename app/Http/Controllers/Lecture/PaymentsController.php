<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\SuccessPayments;
use App\Mail\PaymentLecture;
use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\Survey;
use App\Payments\TossPayments\TossPayments;
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
        $realPrice = $program->canRepeat() ? $program->ticket->repeat_price : $program->ticket->price;

        if ($realPrice != $request->get('amount')) {
            return redirect()->back()->with(['alert' => '결제 금액이 맞지 않습니다.', 'fromApply' => true]);
        }

        $toss = new TossPayments($request->get('paymentKey'));
        $response = $toss->success($request->get('orderId'), $request->get('amount'));

        if ($response === false) {
            return redirect()->back()->with(['alert' => '오류가 발생했습니다.', 'fromApply' => true]);
        }

        $payment = Payment::createByTossSuccess($response);

        $programStudent = ProgramStudent::updateWhenTossSuccess($response, $program, $payment);

        Mail::to(Auth::user()->email)->send(new PaymentLecture(Auth::user(), $this->getProgramQueryWithPayment($payment)));

        return redirect()->route('lectures.result', $program->id);
    }

    private function getProgramQueryWithPayment(Payment $payment)
    {
        return ProgramStudent::query()
            ->select('id', 'payment_id', 'ticket_id', 'expired_at')
            ->where('user_id', '=', Auth::id())
            ->with('payment:id,totalAmount,method', 'ticket.program:id,title')
            ->whereHas('payment', function ($query) use ($payment) {
                $query->where('id', $payment->id);
            })
            ->get()
            ->toArray();
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

        // 새로고침 가능 하게끔.
        session()->flash('fromApply', true);

        return view(viewPrefix() . 'pages.lecture.lecture_payment', [
            'program' => $program,
            'surveys' => $surveys,
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
                $payment = Payment::query()
                    ->where('secret', 'LIKE', $body['secret'])
                    ->where('orderId', 'LIKE', $body['orderId'])
                    ->first();
            } else {
                $payment = Payment::query()
                    ->where('orderId', 'LIKE', $body['orderId'])
                    ->first();
            }

            $payment->update([
                'status' => $body['status'],
                'approvedAt' => now(),
            ]);

            $program = $payment->student->ticket->program;

            $payment->student()->update([
                'payment_id' => $payment->id,
                'expired_at' => $program->is_online ? now()->addDays($program->ticket->term) : $program->place->ended_at,
                'pay_status' => ProgramStudent::$PAY_PAID,
            ]);

            DB::commit();
            return response()->json(['code' => 1], 200);

        } catch (\Exception $e) {
            Log::error('DEPOSIT ERROR', [encrypt($request->all())]);

            DB::rollBack();
            return response()->json(['code' => 2], 500);
        }
    }

}
