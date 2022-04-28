<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Recruit;
use App\Services\Recruit\RecruitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecruitCancelController extends Controller
{
    private $recruitService;

    public function __construct(RecruitService $recruitService)
    {
        $this->recruitService = $recruitService;
    }


    public function cancel(Request $request, Recruit $recruit): JsonResponse
    {
        $cancelDto = $this->recruitService->validateAdminCancel($request, $recruit);
        if ($cancelDto === null) {
            return response()->json(['message' => '유효하지 않은 요청입니다.'], 422);
        }

        $result = $this->recruitService->cancel($recruit, $cancelDto);
        if (!$result) {
            return response()->json(['message' => '오류가 발생했습니다.'], 500);
        }

        return response()->json(['message' => '구인등록 결제취소 되었습니다.']);
    }
}
