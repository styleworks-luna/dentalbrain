<?php


namespace App\Services\Program;


use App\Models\Program\Program;
use App\Models\Program\ProgramMajorCategory;
use App\Models\Program\ProgramMinorCategory;
use App\Models\Program\ProgramTicket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class ProgramTemplate
{
    public $is_online;
    public $program = null;

    /**
     * ProgramTemplate constructor.
     * @param bool|int $is_online
     */
    public function __construct($is_online)
    {
        $this->is_online = $is_online;
    }

    /**
     * @return JsonResponse
     */
    function getPrograms()
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
    function getStudents(Program $program)
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
        $v = Validator::make($request->all(), [
                'major_category' => ['required', 'numeric'],
                'minor_category' => ['required', 'numeric'],
                'title' => ['required', 'string', 'max:200'],
                'description' => ['required',],
                'thumbnail_id' => ['required', 'numeric'],
                'ticket_name' => ['required']
            ] + $this->additionalRules())
            ->sometimes('running_time', ['required', 'string'], function ($input) {
                return $this->is_online == true;
            });
        $validatedData = $v->validate();

        return $validatedData;
    }

    /**
     * 추가적으로 validation 해야하는 것들.
     *
     * @return array
     */
    abstract function additionalRules();

    /**
     * 프로그램 생성.
     *
     * @param array $data
     * @return Program
     */
    function storeProgram(array $data)
    {
        $this->program = Program::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'is_online' => $this->is_online,
            'major_category_id' => $data['major_category'],
            'minor_category_id' => $data['minor_category'],
            'running_time' => $data['running_time'] ?? null,
            'thumbnail_id' => $data['thumbnail_id'],
        ]);

        return $this->program;
    }

    function setProgram(Program $program)
    {
        $this->program = $program;
    }

    function createTickets($data)
    {
        ProgramTicket::create();
    }
}
