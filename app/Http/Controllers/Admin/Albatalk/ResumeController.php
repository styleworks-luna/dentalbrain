<?php

namespace App\Http\Controllers\Admin\Albatalk;

use App\Http\Controllers\Controller;
use App\Models\Resume\Resume;
use App\Services\Recruit\ResumeService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ResumeController extends Controller
{
    public function index(ResumeService $resumeService)
    {
        $listForAdmin = $resumeService->listForAdmin();
        return response()->json($listForAdmin);
    }

    public function detailPdf(ResumeService $resumeService, Resume $resume)
    {
        return $resumeService->getPdf($resume)->stream('이력서.pdf');
    }
}
