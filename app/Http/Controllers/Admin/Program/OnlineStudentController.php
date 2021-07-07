<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Services\Search\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnlineStudentController extends OnlineProgramController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  강의 수강 현황
     *
     * @param Request $request
     * @param Program $program
     * @return JsonResponse
     */
    public function students(Request $request, Program $program)
    {
        $order = $request->get('order', 'latest');
        $keyword = $request->get('keyword', null);

        return response()->json([
            'program_name' => $program->title,
            'students' => $this->onlineConcrete
                ->searchStudents($program, $order, $keyword)->paginate(10),
        ]);
    }
}
