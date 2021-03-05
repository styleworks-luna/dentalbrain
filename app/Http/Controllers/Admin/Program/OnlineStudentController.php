<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\Program;
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
     * @param Program $program
     * @return JsonResponse
     */
    public function students(Request $request,Program $program)

    {
        return response()->json([
            'program_name' => $program->title,
            'students' => $this->onlineConcrete->getStudents($program,10,$request->order)
        ]);
    }
}
