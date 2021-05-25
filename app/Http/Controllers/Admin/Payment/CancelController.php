<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use App\Services\Program\ProgramCancelTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CancelController extends Controller
{
    /**
     * 어드민 환불 처리
     *
     * @param Request $request
     * @param Program $program
     * @param ProgramStudent $student
     * @return JsonResponse
     * @see OfflineStudentController @cancel
     */
    public function cancel(Request $request, Program $program, ProgramStudent $student): JsonResponse
    {
        $concrete = ProgramCancelTemplate::getProgramCancelConcrete($program);

        $validatedData = $concrete->validateAdminCancel($request, $program, User::find($student->user_id));
        if ($validatedData === false) {
            return response()->json(['message' => '유효하지 않은 요청입니다.'], 422);
        }

        $response = $concrete->cancel($program, $student, $validatedData);

        if ($response === false) {
            return response()->json(['message' => '취소 오류 발생 하였습니다.'], 500);
        }
        return response()->json(['message' => '취소되었습니다.']);
    }

    public function revert(Request $request, Program $program, ProgramStudent $student): JsonResponse
    {
        if ($student->pay_status != ProgramStudent::$PAY_ANOTHER_PAID) {
            return response()->json(['message' => '계좌 입금 확인되지 않았습니다.'],400);
        }

        $concrete = ProgramCancelTemplate::getProgramCancelConcrete($program);

        $concrete->revert($program, $student);

        return response()->json(['message' => '미 결제 상태로 전환되었습니다.']);
    }
}
