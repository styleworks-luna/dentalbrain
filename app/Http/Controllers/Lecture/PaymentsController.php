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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class PaymentsController extends Controller
{
    public function success(SuccessPayments $request, Program $program)
    {
        if ($program->ticket->price != $request->get('amount')) {
            return redirect()->back()->with(['alert' => '결제 금액이 맞지 않습니다.']);
        }

        $toss = new TossPayments($request->get('paymentKey'));
        $response = $toss->success($request->get('orderId'), $request->get('amount'));

        if ($response === false) {
            return redirect()->back()->with(['alert' => '오류가 발생했습니다.']);
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

    public function showPaymentForm(Request $request, Program $program)
    {
        if (!$request->session()->get('fromApply', false)) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        $surveys = Survey::result($program->id)->get();

        return view(viewPrefix() . 'pages.lecture.lecture_payment', [
            'program' => $program,
            'surveys' => $surveys,
        ]);
    }

    public function deposited(Request $request)
    {
        $v = Validator::make($request->all(), [
            'secret' => ['required', 'string'],
            'status' => ['required', Rule::in(['DONE', 'CANCELED'])],
            'orderId' => ['required', 'string'],
        ]);

        $body = $v->validate();

        try {
            $payment = Payment::query()
                ->where('secret', 'LIKE', $body['secret'])
                ->where('orderId', 'LIKE', $body['orderId'])
                ->first();

            $tossPayment = new TossPayments($payment->paymentKey);

            $payment->update([
                'status' => $body['status'],
                'approvedAt' => now(),
            ]);

            $payment->student->update([
                'payment_id' => $payment->id,
                'expired_at' => now()->addDays($payment->student->ticket->term),
                'pay_status' => ProgramStudent::$PAY_PAID,
            ]);

            return response('', 200);

        } catch (\Exception $e) {
            Log::error('DEPOSIT ERROR', [encrypt($request->all())]);
            return response('', 500);
        }
    }

}
