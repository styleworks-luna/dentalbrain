<?php

namespace App\Http\Controllers\Admin\Program;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use App\Services\Program\OnlineProgramConcrete;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class OnlineProgramController extends Controller
{
    protected $onlineConcrete;
    private $search;

    public function __construct()
    {
        $this->onlineConcrete = new OnlineProgramConcrete();
    }

    public function getCategories()
    {
        return $this->onlineConcrete->getCategories();
    }

    public function index(Request $request)
    {
        return response()->json([
            'programs' => $this->search($request),
        ]);
    }

    private function search(Request $request)
    {
        $this->search = new SearchService(Program::query());

        $this->search->addKeyword('title', $request->keyword);
        $this->addMajorCategoryId($request);
        $this->addMinorCategoryId($request);

        $search = $this->search->search()->where('is_online', '=', 1)
            ->withCount('students')->orderByDesc('id')->paginate('10');

        return $search;
    }

    private function addMajorCategoryId(Request $request)
    {
        if (isset($request->major_category_id) && is_numeric($request->major_category_id)) {
            $this->search->addCategory('major_category_id', '=', $request->major_category_id);
        }
    }

    private function addMinorCategoryId(Request $request)
    {
        if (isset($request->minor_category_id) && is_numeric($request->minor_category_id)) {
            $this->search->addCategory('minor_category_id', '=', $request->minor_category_id);
        }
    }

    public function changeOpen(Request $request, Program $program)
    {
        $this->onlineConcrete->changeOpenStatus($program);
        return response()->json([
            'is_open' => $program->is_open,
            'msg' => '변경되었습니다.'
        ]);
    }

    public function store(Request $request)
    {
        $programData = $this->onlineConcrete->validateProgram($request,
            [
                'running_time' => ['required', 'string']
            ]);

        $ticketData = $this->onlineConcrete->validateTickets($request);

        $surveyDateSet = $this->onlineConcrete->validateSurveys($request);

        $lectureDataSet = $this->onlineConcrete->validateLectures($request);

        try {
            DB::beginTransaction();

            $program = $this->onlineConcrete->storeProgram($programData);
            $ticket = $this->onlineConcrete->storeTickets($program, $ticketData);
            $surveys = $this->onlineConcrete->storeSurveys($program, $surveyDateSet);
            $lectures = $this->onlineConcrete->storeLectures($program, $lectureDataSet);

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ONLINE PROGRAM STORE ERROR',
                [$exception, $programData, $ticketData, $surveyDateSet, $lectureDataSet]);
            return response()->json([
                'msg' => '오류가 발생했습니다.',
            ], 500);
        }
        DB::commit();

        return response()->json([
            'msg' => '온라인 강의가 생성되었습니다.',
        ]);
    }

    public function edit(Program $program)
    {
        return response()->json(
            array_merge($this->onlineConcrete->getProgramDetail($program),
                ['lectures' => $program->lectures()->with('thumbnail:id,url,name')->get()])
        );
    }

    public function update(Request $request, Program $program)
    {
        $programData = $this->onlineConcrete->validateProgram($request, [
            'running_time' => ['required', 'string']
        ]);

        $ticketData = $this->onlineConcrete->validateTickets($request);

        $surveyDataSet = $this->onlineConcrete->validateSurveys($request, [
            '*.id' => ['sometimes', 'required', Rule::exists('surveys', 'id')],
            '*.choices.*.id' => ['sometimes', Rule::exists('surveys', 'id')],
            '*.choices.*.parent_id' => ['sometimes', 'nullable', Rule::exists('surveys', 'id')],
        ]);

        $lectureDataSet = $this->onlineConcrete->validateLectures($request, [
            'lectures.*.id' => ['sometimes', 'required', Rule::exists('lectures', 'id')]
        ]);

        try {
            DB::beginTransaction();

            $this->onlineConcrete->updateProgram($program, $programData);
            $this->onlineConcrete->updateTickets($program, $ticketData);
            $this->onlineConcrete->updateSurveys($program, $surveyDataSet);
            $this->onlineConcrete->updateLectures($program, $lectureDataSet);

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ONLINE PROGRAM STORE ERROR',
                [$exception]);
            return response()->json([
                'msg' => '오류가 발생했습니다.',
            ], 500);
        }
        DB::commit();

        return response()->json([
            'msg' => '온라인 강의가 수정되었습니다.',
        ]);
    }

    public function cancel(Request $request, Program $program, ProgramStudent $student)
    {
        $response = $this->onlineConcrete->cancel($request, $program, User::find($student->user_id));
        if ($response === false) {
            return response()->json(['msg' => '실패']);
        }
        //TODO : response로 payment 갱신하기.
    }
}
