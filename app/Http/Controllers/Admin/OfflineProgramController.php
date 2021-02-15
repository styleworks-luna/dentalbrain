<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Services\Program\OfflineProgramConcrete;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class OfflineProgramController extends Controller
{
    protected $offlineConcrete;
    private $search;

    public function __construct()
    {
        $this->offlineConcrete = new OfflineProgramConcrete();
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

        $search = $this->search->search()->where('is_online', '=', $this->offlineConcrete->is_online)
            ->with('place:id,program_id,started_at,ended_at')
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
        $this->offlineConcrete->changeOpenStatus($program);
        return response()->json(['is_open' => $program->is_open]);
    }

    public function students(Program $program)
    {
        return $this->offlineConcrete->getStudents($program);
    }

    public function edit(Program $program)
    {
        return response()->json(
            array_merge($this->offlineConcrete->getProgramDetail($program),
                ['place' => $program->place])
        );
    }

    public function store(Request $request)
    {
        $programData = $this->offlineConcrete->validateProgram($request);
        $ticketData = $this->offlineConcrete->validateTickets($request);
        $surveyDataSet = $this->offlineConcrete->validateSurveys($request);
        $placeData = $this->offlineConcrete->validatePlace($request);

        try {
            DB::beginTransaction();
            $program = $this->offlineConcrete->storeProgram($programData);
            $this->offlineConcrete->storeTickets($program, $ticketData);
            $this->offlineConcrete->storeSurveys($program, $surveyDataSet);
            $this->offlineConcrete->storePlace($program, $placeData);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ONLINE PROGRAM STORE ERROR',
                [$exception, $programData, $ticketData, $surveyDataSet]);
            return response()->json([
                'msg' => '오류가 발생했습니다.',
            ], 500);
        }
        DB::commit();

        return response()->json([
            'msg' => '오프라인 강의가 생성되었습니다.',
        ]);
    }

    public function getCategories()
    {
        return $this->offlineConcrete->getCategories();
    }

    public function update(Request $request, Program $program)
    {
        $programData = $this->offlineConcrete->validateProgram($request);
        $ticketData = $this->offlineConcrete->validateTickets($request);
        $surveyDataSet = $this->offlineConcrete->validateSurveys($request, [
            '*.id' => ['sometimes', 'required', Rule::exists('surveys', 'id')],
            '*.choices.*.id' => ['sometimes', Rule::exists('surveys', 'id')],
            '*.choices.*.parent_id' => ['sometimes', 'nullable', Rule::exists('surveys', 'id')],
        ]);
        $placeData = $this->offlineConcrete->validatePlace($request, [
            'id' => ['required', Rule::exists('program_places', 'id')],
        ]);

        try {
            DB::beginTransaction();
            $program = $this->offlineConcrete->updateProgram($program, $programData);
            $this->offlineConcrete->updateTickets($program, $ticketData);
            $this->offlineConcrete->updateSurveys($program, $surveyDataSet);
            $this->offlineConcrete->updatePlace($program, $placeData);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ONLINE PROGRAM STORE ERROR',
                [$exception, $programData, $ticketData, $surveyDataSet]);
            return response()->json([
                'msg' => '오류가 발생했습니다.',
            ], 500);
        }
        DB::commit();

        return response()->json([
            'msg' => '오프라인 강의가 수정되었습니다.',
        ]);
    }
}
