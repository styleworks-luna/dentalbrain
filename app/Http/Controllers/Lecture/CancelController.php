<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Mail\RequestProgramCancel;
use App\Mail\RequestProgramCancelAdmin;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Services\Program\OfflineProgramCancelConcrete;
use App\Services\Program\ProgramCancelTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CancelController extends Controller
{
    /**
     *  유저 측 자동 환불 요청 받는 컨트롤러 로직
     *
     * @param Request $request
     * @param Program $program
     * @return JsonResponse
     */
    public function cancel(Request $request, Program $program): JsonResponse
    {
        $concrete = ProgramCancelTemplate::getProgramCancelConcrete($program);

        $student = Auth::user()->students()->where('ticket_id', '=', $program->ticket->id)->first();

        if ($student->pay_status == ProgramStudent::$PAY_PAID) {
            // PG사 통한 결제일 경우.
            $data = $concrete->validateUserCancel($request, $program);
            if ($data == false) {
                // validation 실패 처리
                return response()->json([
                    'msg' => '유효하지 않은 요청입니다.'
                ], 422);
            }
            $success = $concrete->cancel($program, $student, $data);
        } else {
            $success = $concrete->cancel($program, $student);
        }

        if (!$success) {
            // 실패
            // 서버 오류 처리
            Log::error('USER AUTO CANCEL ERROR IN CONCRETE', [$request->all(), 'ID' => Auth::id()]);
            return response()->json([
                'msg' => '환불 실패하였습니다.'
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
     * @return JsonResponse
     */
    public function cancelRequest(Request $request, Program $program): JsonResponse
    {
        if ($program->is_online) {
            // 현재 오프라인에만 환불 요청 받고 있음.
            return response()->json([
                'msg' => '유효하지 않은 요청입니다.'
            ], 422);
        }
        $concrete = new OfflineProgramCancelConcrete();
        $data = $concrete->validateUserRequestCancel($request, $program);
        if ($data == false) {
            // validation failed
            return response()->json([
                'msg' => '유효하지 않은 요청입니다.'
            ], 422);
        }

        $student = $program->students()->where('user_id', '=', Auth::id())->first();

        // 환불 요청 상태 저장.
        $student->update([
            'pay_status' => ProgramStudent::$PAY_IN_REFUND_PROCESS,
        ]);

        // 유저에게 환불 요청 알림
        Mail::to(Auth::user()->email)
            ->send(new RequestProgramCancel($student,
                $request->get('reason'), $request->get('bank'),
                $request->get('accountNumber'), $request->get('holderName')));

        // 관리자에게 환불 요청 알림
        Mail::to(config('mail.admin_emails', ['dentalbrainon@gmail.com']))
            ->send(new RequestProgramCancelAdmin($student,
                $request->get('reason'), $request->get('bank'),
                $request->get('accountNumber'), $request->get('holderName')));

        return response()->json([
            'msg' => '요청되었습니다.'
        ]);
    }
}
