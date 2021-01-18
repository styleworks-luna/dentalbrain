<?php

namespace App\Traits;

use App\Models\Program\Program;
use App\Models\Program\ProgramMajorCategory;
use App\Models\Program\ProgramMinorCategory;
use App\Models\Program\ProgramTicket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait ProgramFunctions
{
    public $is_online;

    /**
     * 강의 목록
     *
     * @return JsonResponse
     */
    function programIndex()
    {
        $programs = Program::query()->where('is_online', '=', $this->is_online)
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

    /**
     * @return JsonResponse
     */
    function getCategories()
    {
        $major = ProgramMajorCategory::all();
        $minor = ProgramMinorCategory::all();
        return response()->json([
            'major' => $major,
            'minor' => $minor,
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    function validate(Request $request)
    {
        $data = $request->validate([
                'major_category' => ['required', 'numeric'],
                'minor_category' => ['required', 'numeric'],
                'title' => ['required', 'string', 'max:200'],
                'description' => ['required',],
                'running_time' => ['nullable', 'string'],
                'thumbnail_id' => ['nullable', 'numeric'],
            ] + $this->additionalRules()
        );

        return $data;
    }

    /**
     * 추가적으로 validation 해야하는 것들.
     *
     * @return array
     */
    function additionalRules()
    {
        // 추가적으로 validation 필요한 것들.
        return [];
    }

    function programStore(array $data)
    {
        return Program::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'is_online' => $this->is_online,
            'major_category_id' => $data['major_category'],
            'minor_category_id' => $data['minor_category'],
            'running_time' => $data['running_time'] ?? null,
            'thumbnail_id' => $data['thumbnail_id'] ?? 1,
        ]);
    }

    function createTickets(Program $program, $data)
    {
        ProgramTicket::create();
    }

}
