<?php

namespace App\Traits;

use App\Models\Program\Program;
use Illuminate\Http\JsonResponse;

trait ProgramFunctions
{
    /**
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
}
