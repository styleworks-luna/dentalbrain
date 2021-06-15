<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Services\Membership\MembershipService;
use App\Services\Program\ProgramCancelTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $cancelDto = $concrete->validateAdminCancel($request, $program, $student->user);
        if ($cancelDto === null) {
            return response()->json(['message' => '유효하지 않은 요청입니다.'], 422);
        }

        $response = $concrete->cancel($program, $student, $cancelDto);
        if ($response === false) {
            return response()->json(['message' => '취소 오류 발생 하였습니다.'], 500);
        }

        return response()->json(['message' => '취소되었습니다.']);
    }

    public function revert(Request $request, Program $program, ProgramStudent $student): JsonResponse
    {
        if ($student->pay_status != ProgramStudent::$PAY_ANOTHER_PAID) {
            return response()->json(['message' => '계좌 입금 확인되지 않았습니다.'], 400);
        }

        $concrete = ProgramCancelTemplate::getProgramCancelConcrete($program);

        try {
            DB::beginTransaction();

            $concrete->revert($program, $student);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('program revert error', [$exception, $program, $student]);
        }

        return response()->json(['message' => '미 결제 상태로 전환되었습니다.']);
    }

    public function cancelMembership(Request $request, Membership $membership)
    {
        $membershipService = new MembershipService();

        $cancelDto = $membershipService->validateAdminCancel($request, $membership);
        if ($cancelDto === null) {
            return response()->json(['message' => '유효하지 않은 요청입니다.'], 422);
        }

        $result = $membershipService->cancel($membership, $cancelDto);
        if ($result == false) {
            return response()->json(['message' => '오류가 발생했습니다.'], 500);
        }

        return response()->json(['message' => '유료회원 삭제되었습니다.']);
    }
}
