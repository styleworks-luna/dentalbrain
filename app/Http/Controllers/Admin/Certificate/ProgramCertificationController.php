<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Services\Certificate\ProgramCertificateService;
use App\Traits\HasCertificateStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'category' => ['nullable', 'numeric'],
            'keyword' => ['nullable', 'string']
        ]);

        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;

        $result = $this->programCertificateService->searchProgramsCertificateProfiles($program, $keyword, $category);

        return response()->json($result);
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
}
