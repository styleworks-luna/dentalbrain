<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Services\Membership\MembershipService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MembershipCancelController extends Controller
{
    public function cancel(Request $request, Membership $membership): JsonResponse
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
