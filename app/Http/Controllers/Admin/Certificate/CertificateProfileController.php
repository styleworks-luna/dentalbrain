<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificateQualification;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\File;
use App\Models\Program\Program;
use App\Services\Certificate\CertificateService;
use App\Services\File\CertificateThumbnail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
        if ($status == QualificationProfile::$PASS) {
            $profile->passed_at = now();
        } else {
            $profile->passed_at = null;
        }

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
            $profile->passed_at = now();
        } else {
            $profile->certificate_number = null;
            $profile->passed_at = null;
        }

        $profile->status = $status;
        $profile->save();

        return response()->json(['msg' => '변경되었습니다.']);
    }

    public function getCompletionProfile(Request $request, Program $program, CompletionProfile $profile): JsonResponse
    {
        return response()->json($profile->load('file', 'user')->toArray());
    }

    public function getQualificationProfile(Request $request, Program $program, QualificationProfile $profile): JsonResponse
    {
        return response()->json($profile->load('file', 'user')->toArray());
    }

    public function updateCompletionProfile(Request $request, Program $program, CompletionProfile $profile): JsonResponse
    {
        $completionValidator = Validator::make($request->all(), [
            'file_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:50'],
            'university' => ['nullable', 'string', 'max:50'],
            'student_number' => ['nullable', 'string', 'max:20'],
            'birthday' => ['required', 'string', 'max:20', 'regex:/\d{4}\.\d{1,2}\.\d{1,2}/x'],
            'score' => ['required', 'numeric'],
        ]);
        if ($completionValidator->fails()) {
            return response()->json($completionValidator->errors(), 400);
        }
        $completionData = $completionValidator->validated();

        if ($profile->file != null && $completionData['file_id'] != $profile->file->id) {
            $certificateThumbnail = new CertificateThumbnail($profile);
            $certificateThumbnail->deleteFile();
            $file = $certificateThumbnail->moveTempToPublic(File::find($completionData['file_id']));
            if (!$file) {
                Log::error("QUALIFICATION PROFILE UPDATE ERROR");
                return response()->json(['msg' => '에러가 발생했습니다.'], 500);
            }
        }

        $profile->update([
            'file_id' => $completionData['file_id'],
            'name' => $completionData['name'],
            'university' => $completionData['university'] ?? null,
            'student_number' => $completionData['student_number'] ?? null,
            'birthday' => $completionData['birthday'],
            'score' => $completionData['score'],
        ]);

        return response()->json([
            'message' => '변경되었습니다.',
            'completionProfile' => $profile
        ]);
    }

    public function updateQualificationProfile(Request $request, Program $program, QualificationProfile $profile): JsonResponse
    {
        $qualificationValidator = Validator::make($request->all(), [
            'file_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:50'],
            'university' => ['nullable', 'string', 'max:50'],
            'student_number' => ['nullable', 'string', 'max:20'],
            'birthday' => ['required', 'string', 'max:20', 'regex:/\d{4}\.\d{1,2}\.\d{1,2}/x'],
            'score' => ['required', 'numeric'],
        ]);
        if ($qualificationValidator->fails()) {
            if ($qualificationValidator->fails()) {
                return response()->json($qualificationValidator->errors(), 400);
            }
        }
        $qualificationData = $qualificationValidator->validated();

        if ($profile->file != null && $qualificationData['file_id'] != $profile->file->id) {
            $certificateThumbnail = new CertificateThumbnail($profile);
            $certificateThumbnail->deleteFile();
            $file = $certificateThumbnail->moveTempToPublic(File::find($qualificationData['file_id']));
            if (!$file) {
                Log::error("QUALIFICATION PROFILE UPDATE ERROR");
                return response()->json(['msg' => '에러가 발생했습니다.'], 500);
            }
        }

        $profile->update([
            'file_id' => $qualificationData['file_id'],
            'name' => $qualificationData['name'],
            'university' => $qualificationData['university'] ?? null,
            'student_number' => $qualificationData['student_number'] ?? null,
            'birthday' => $qualificationData['birthday'],
            'score' => $qualificationData['score'],
        ]);

        return response()->json([
            'message' => '변경되었습니다.',
            'completionProfile' => $profile
        ]);
    }

    public function issueCompletion(CompletionProfile $profile): JsonResponse
    {
        $profile->is_issued = true;
        $profile->save();

        return response()->json([
            'msg' => '발급되었습니다.'
        ]);
    }

    public function issueQualification(QualificationProfile $profile): JsonResponse
    {
        $profile->is_issued = true;
        $profile->save();

        return response()->json([
            'msg' => '발급되었습니다.'
        ]);
    }
}
