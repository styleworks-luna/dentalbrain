<?php

namespace App\Traits;

use App\Models\Program\Program;
use Illuminate\Http\JsonResponse;

trait ProgramFunctions
{
    /**
     * 강의 목록
     *
     * @param boolean|integer $is_online
     * @return JsonResponse
     */
    function programIndex($is_online)
    {
        $programs = Program::query()->where('is_online', '=', 1)
            ->withCount('students')->orderByDesc('id')->paginate('10');
        return response()->json([
            'programs' => $programs,
        ]);
    }

    /**
     * 강의 수강현황
     *
     * @param Program $program
     * @return JsonResponse
     */
    function getStudentInfo(Program $program)
    {
        $students = $program->students()->orderByDesc('id')->with('ticket')->paginate(10);
        return response()->json([
            'students' => $students,
        ]);
    }
}
