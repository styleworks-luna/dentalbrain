<?php

namespace App\Http\Controllers\Admin\Albatalk;

use App\Http\Controllers\Controller;
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
}
