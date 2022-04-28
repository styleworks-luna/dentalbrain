<?php

namespace App\Http\Controllers\Admin\Albatalk;

use App\Http\Controllers\Controller;
use App\Models\Resume\Resume;
use App\Services\Recruit\ResumeService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ResumeController extends Controller
{
    private $resumeService;

    public function __construct(ResumeService $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => ['nullable', 'string'],
        ]);

        $listForAdmin = $this->resumeService->searchForAdmin($request->get('keyword', null));
        return response()->json($listForAdmin);
    }

    public function detailPdf(Resume $resume)
    {
        return $this->resumeService->getPdf($resume)->stream('이력서.pdf');
    }
}
