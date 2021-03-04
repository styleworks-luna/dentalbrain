<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\SuccessPayments;
use App\Mail\PaymentLecture;
use App\Mail\RequestProgramCancel;
use App\Mail\RequestProgramCancelAdmin;
use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\Survey;
use App\Payments\TossPayments\TossPayments;
use App\Services\Program\OfflineProgramConcrete;
use App\Services\Program\OnlineProgramConcrete;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    /**
     *  유저 측 자동 환불 요청 받는 컨트롤러 로직
     *
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, Program $program)
    {
        if ($program->is_online) {
            $concrete = new OnlineProgramConcrete();
        } else {
            $concrete = new OfflineProgramConcrete();
        }

        $student = Auth::user()->students()->where('ticket_id', '=', $program->ticket->id)->first();

        $data = $concrete->validateUserCancel($request, $program);
        if ($data == false) {
            // validation 실패 처리
            return response()->json([
                'msg' => '유효하지 않은 요청입니다.'
            ], 422);
        }

        $success = $concrete->cancel($program, $student, $data);

        if (!$success) {
            // 실패
            // 서버 오류 처리
            Log::error('USER AUTO CANCEL ERROR IN CONCRETE', [$request->all(), 'ID' => Auth::id()]);
            return response()->json([
                'msg' => '오류가 발생했습니다.'
            ], 500);
        }

        return response()->json([
            'msg' => '환불이 완료되었습니다.',
        ]);
    }


    /**
     *  유저 측 관리자 수동 환불 요청 받는 컨트롤러 로직
     *
     * @param Request $request
     * @param Program $program
     */
    public function cancelRequest(Request $request, Program $program)
    {
        if ($program->is_online) {
            return response()->json([
                'msg' => '유효하지 않은 요청입니다.'
            ], 422);
        }
        $concrete = new OfflineProgramConcrete();
        $data = $concrete->validateUserRequestCancel($request, $program);
        if ($data == false) {
            return response()->json([
                'msg' => '유효하지 않은 요청입니다.'
            ], 422);
        }

        $student = $program->students()->where('user_id', '=', Auth::id())->first();

        Mail::to($student->email)
            ->send(new RequestProgramCancel($student,
                $request->get('reason'), $request->get('bank'),
                $request->get('accountNumber'), $request->get('holderName')));

        Mail::to(config('mail.admin_emails', ['dentalbrainon@gmail.com']))
            ->send(new RequestProgramCancelAdmin($student,
                $request->get('reason'), $request->get('bank'),
                $request->get('accountNumber'), $request->get('holderName')));

        return response()->json([
            'msg' => '요청되었습니다.'
        ]);
    }

    /**
     * 토스에서 가상계좌 입금이 완료 콜백.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
            $payment = Payment::query()
                ->where('secret', 'LIKE', $body['secret'])
                ->where('orderId', 'LIKE', $body['orderId'])
                ->first();

            $payment->update([
                'status' => $body['status'],
                'approvedAt' => now(),
            ]);

            $payment->student()->update([
                'payment_id' => $payment->id,
                'expired_at' => now()->addDays($payment->student->ticket->term),
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
