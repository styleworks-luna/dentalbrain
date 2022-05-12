<?php

namespace App\Http\Controllers\Admin\Program;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Services\Program\ProgramTemplate;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;

class BaseProgramController extends Controller
{
    protected $search;

    public function getCategories(): \Illuminate\Http\JsonResponse
    {
        return ProgramTemplate::getCategories();
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'programs' => $this->search($request),
        ]);
    }

    protected function addMajorCategoryId(Request $request)
    {
        if (isset($request->major_category_id) && is_numeric($request->major_category_id)) {
            $this->search->addCategory('major_category_id', '=', $request->major_category_id);
        }
    }

    protected function addMinorCategoryId(Request $request)
    {
        if (isset($request->minor_category_id) && is_numeric($request->minor_category_id)) {
            $this->search->addCategory('minor_category_id', '=', $request->minor_category_id);
        }
    }

    public function changeOpen(Request $request, Program $program): \Illuminate\Http\JsonResponse
    {
        ProgramTemplate::changeOpenStatus($program);

        return response()->json([
            'is_open' => $program->is_open,
            'msg' => '변경되었습니다.'
        ]);
    }
}
