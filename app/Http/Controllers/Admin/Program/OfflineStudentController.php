<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\Program;
use Illuminate\Http\JsonResponse;

class OfflineStudentController extends OfflineProgramController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 강의 수강 현황
     *
     * @param Program $program
     * @return JsonResponse
     */
    public function students(Program $program)
    {
        return response()->json([
            'program_name' => $program->title,
            'students' => $this->offlineConcrete->getStudents($program)
        ]);
    }

}
