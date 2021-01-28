<?php


namespace App\Services\Program;


use App\Models\Program\Program;
use App\Models\Program\ProgramMajorCategory;
use App\Models\Program\ProgramMinorCategory;
use App\Models\Program\ProgramTicket;
use App\Models\Program\Survey\Survey;
use App\Models\Program\Survey\SurveyCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $major = ProgramMajorCategory::query()->select(['id', 'name'])->get();
        $minor = ProgramMinorCategory::query()->select(['id', 'name'])->get();
        return response()->json([
            'major' => $major,
            'minor' => $minor,
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    function validateProgram(Request $request)
    {
        $v = Validator::make($request->all(), array_merge([
            'major_category_id' => ['required', 'numeric'],
            'minor_category_id' => ['required', 'numeric'],
            'title' => ['required', 'string', 'max:200'],
            'thumbnail_id' => ['required', 'numeric'],
            'content' => ['required', 'string'],
        ], $this->additionalRules()))
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

    function validateSurveys(Request $request)
    {
        $hasChoices = ['singleChoice', 'multipleChoice'];

        $v = Validator::make($request->all(), [
            'surveys.*.type' => ['required', Rule::exists('survey_categories', 'eng_name')],
            'surveys.*.question' => ['required', 'string'],
            'surveys.*.is_required' => ['required', 'boolean'],
            'surveys.*.choices' => ['sometimes', 'required', 'array'],
        ]);
        $validatedData = $v->validate();

        return $validatedData['surveys'];
    }

    function validateTickets(Request $request)
    {
        $v = Validator::make($request->all(), [
            'lecture_info' => ['required', 'string'],
            'is_free' => ['required', 'boolean'],
            'price' => ['nullable', 'numeric'],
        ]);
        $validatedData = $v->validate();

        return $validatedData;
    }

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
            'content' => $data['content'],
            'is_online' => $this->is_online,
            'major_category_id' => $data['major_category_id'],
            'minor_category_id' => $data['minor_category_id'],
            'running_time' => $data['running_time'] ?? null,
            'thumbnail_id' => $data['thumbnail_id'],
        ]);

        return $this->program;
    }

    /**
     * @param Program $program
     * @param $data
     * @return mixed
     */
    function storeTickets(Program $program, $data)
    {
        return ProgramTicket::create([
            'price' => $data['price'],
            'is_free' => $data['is_free'],
            'name' => $data['lecture_info'],
            'program_id' => $program->id,
            //'term' => 100 days default.
        ]);
    }

    /**
     * @param Program $program
     * @param $dataSet
     * @return array
     */
    function storeSurveys(Program $program, $dataSet)
    {
        $returnableDataSet = [];
        foreach ($dataSet as $data) {
            $parent = Survey::create([
                'category_id' => SurveyCategory::castStringTypeToId($data['type']),
                'program_id' => $program->id,
                'question' => $data['question'],
                'is_required' => $data['is_required'],
            ]);
            $returnableDataSet[] = $parent;
            if (SurveyCategory::hasChoices($data['type'])) {
                // 선택지가 있는 경우.
                foreach ($data['choices'] as $choice) {
                    $choice = Survey::create([
                        'category_id' => SurveyCategory::castStringTypeToId($data['type']),
                        'program_id' => $program->id,
                        'question' => $choice,
                        'is_required' => $data['is_required'],
                        'parent_id' => $parent->id,
                    ]);
                    $returnableDataSet[] = $choice;
                }
            }
        }
        return $returnableDataSet;
    }
}
