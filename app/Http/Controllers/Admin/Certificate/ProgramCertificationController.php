<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Exports\CertificationExport;
use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\File;
use App\Models\Program\Program;
use App\Services\Certificate\ProgramCertificateService;
use App\Services\File\CertificateThumbnail;
use App\Traits\HasCertificateStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProgramCertificationController extends Controller
{
    /**
     * @var ProgramCertificateService
     */
    private $programCertificateService;
    /**
     * @param ProgramCertificateService $programCertificateService
     */
    public function __construct(ProgramCertificateService $programCertificateService)
    {
        $this->programCertificateService = $programCertificateService;
    }


    public function index(Request $request, Program $program): JsonResponse
    {
        $validated = $request->validate([
            'category' => ['nullable', Rule::in('ongoing', 'ended')],
            'keyword' => ['nullable', 'string']
        ]);

        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;

        $result = $this->programCertificateService->searchProgramsCertificateProfiles($program, $keyword, $category);

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @param Program $program
     * @return BinaryFileResponse
     */
    public function excel(Request $request, Program $program): BinaryFileResponse
    {
        $validated = $request->validate([
            'category' => ['nullable', 'numeric'],
            'keyword' => ['nullable', 'string']
        ]);

        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;


        $profiles = $this->programCertificateService->excelProgramCertificateProfiles($program, $keyword, $category);
        return Excel::download(new CertificationExport($profiles), "{$program->title}_증명서_신청_현황.xlsx");
    }

    public function passAll(Request $request, Program $program): JsonResponse
    {
        $validated = $request->validate([
            'category' => ['nullable', 'numeric'],
            'keyword' => ['nullable', 'string']
        ]);

        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;

        try {
            DB::beginTransaction();
            $this->programCertificateService->updateProgramCertificateProfiles(HasCertificateStatus::$PASS, $program, $keyword, $category);

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('CERTIFICATE UPDATE ERROR', [$exception]);
            return response()->json(['msg' => '오류가 발생하였습니다.']);
        }

        DB::commit();
        return response()->json(['msg' => '합격 처리되었습니다.']);
    }

    public function updateCompletion(Request $request, Program $program, CompletionProfile $profile)
    {
        $completionValidator = Validator::make($request->all(), [
            'file_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:50'],
            'university' => ['required', 'string', 'max:50'],
            'student_number' => ['required', 'string', 'max:20'],
            'birthday' => ['required', 'string', 'max:20', 'regex:/\d{4}\.\d{1,2}\.\d{1,2}/x'],
        ]);
        if ($completionValidator->fails()) {
            return response()->json($completionValidator->errors(),400);
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
            'university' => $completionData['university'],
            'student_number' => $completionData['student_number'],
            'birthday' => $completionData['birthday'],
        ]);

        return response()->json([
            'message' => 'ok',
            'completionProfile' => $profile
        ]);
    }

    public function updateQualification(Request $request, Program $program, QualificationProfile $profile)
    {
        $qualificationValidator = Validator::make($request->all(), [
            'file_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:50'],
            'university' => ['required', 'string', 'max:50'],
            'student_number' => ['required', 'string', 'max:20'],
            'birthday' => ['required', 'string', 'max:20', 'regex:/\d{4}\.\d{1,2}\.\d{1,2}/x'],
        ]);
        if ($qualificationValidator->fails()) {
            if ($qualificationValidator->fails()) {
                return response()->json($qualificationValidator->errors(),400);
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
            'university' => $qualificationData['university'],
            'student_number' => $qualificationData['student_number'],
            'birthday' => $qualificationData['birthday'],
        ]);

        return response()->json([
            'message' => 'ok',
            'completionProfile' => $profile
        ]);
    }
}
