<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificateQualification;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Services\Certificate\CertificateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CertificateProfileController extends Controller
{
    private $certificateService;

    /**
     * @param CertificateService $certificateService
     */
    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }


    public function statusCompletion(Request $request, CompletionProfile $profile): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([CompletionProfile::$WAITING, CompletionProfile::$FAILED, CompletionProfile::$PASS])]
        ]);
        $status = $validated['status'];

        $profile->status = $status;
        $profile->save();

        return response()->json(['msg' => '변경되었습니다.']);
    }

    public function statusQualification(Request $request, QualificationProfile $profile): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([CompletionProfile::$WAITING, CompletionProfile::$FAILED, CompletionProfile::$PASS])]
        ]);
        $status = $validated['status'];

        if ($status == QualificationProfile::$PASS) {
            $profile->certificate_number = $this->certificateService->getCertificationNumberForPassedQualification($profile);
        } else {
            $profile->certificate_number = null;
        }

        $profile->status = $status;
        $profile->save();

        return response()->json(['msg' => '변경되었습니다.']);
    }
}
