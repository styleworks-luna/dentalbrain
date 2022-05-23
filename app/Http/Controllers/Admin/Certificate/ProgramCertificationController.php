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

        return response()->json([
            $result,
            'programTitle' => $program->title
        ]);
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

    public function issueAll(Request $request, Program $program): JsonResponse
    {
        $validated = $request->validate([
            'category' => ['nullable', 'numeric'],
            'keyword' => ['nullable', 'string']
        ]);

        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;

        try {
            DB::beginTransaction();
            $this->programCertificateService->issueProgramCertificateProfiles($program, $keyword, $category);

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('CERTIFICATE UPDATE ERROR', [$exception]);
            return response()->json(['msg' => '오류가 발생하였습니다.']);
        }

        DB::commit();
        return response()->json(['msg' => '발급 처리되었습니다.']);
    }
}
