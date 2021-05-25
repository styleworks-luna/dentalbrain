<?php

namespace App\Http\Controllers\Admin\Program;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Services\File\LectureThumbnail;
use App\Services\File\ProgramMaterial;
use App\Services\File\ProgramThumbnail;
use App\Services\Program\OnlineProgramConcrete;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class OnlineProgramController extends BaseProgramController implements ProgramControllerInterface
{
    protected $onlineConcrete;
    private $search;

    public function __construct()
    {
        $this->onlineConcrete = new OnlineProgramConcrete();
    }

    public function search(Request $request)
    {
        $this->search = new SearchService(Program::query());

        $this->search->addKeyword('title', $request->keyword);
        $this->addMajorCategoryId($request);
        $this->addMinorCategoryId($request);

        $search = $this->search->search()->where('is_online', '=', 1)
            ->withCount(['students' => function ($query) {
                $query->where('pay_status', '!=', ProgramStudent::$PAY_BEFORE)
                    ->where('pay_status', '!=', ProgramStudent::$PAY_REFUNDED);
            }])->orderByDesc('id')->paginate('10');
        return $search;
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

    public function duplicateEdit(Program $program)
    {
        return $this->edit($program);
    }

    public function edit(Program $program)
    {
        return response()->json(
            array_merge($this->onlineConcrete->getProgramDetail($program), [
                'lectures' => $program->lectures()->with('thumbnail:id,url,name')->get(),
                'haveStudents' => $program->students()->exists()
            ])
        );
    }

    public function duplicate(Request $request, Program $program)
    {
        $duplicatedThumbnail = ProgramThumbnail::duplicate(File::find($request['thumbnail_id']));
        $request['thumbnail_id'] = $duplicatedThumbnail->id;

        foreach ($request['lectures'] as $key => $lecture) {
            if ($lecture['thumbnail_id'] == null) continue;
            $duplicated = LectureThumbnail::duplicate(File::find($lecture['thumbnail_id']));
            $data[$key]['thumbnail_id'] = $duplicated->id;
            $request->merge($data);
        }

        if ($request->get('material_id') != null) {
            $duplicatedMaterial = ProgramMaterial::duplicate(File::find($request['material_id']));
            $request['material_id'] = $duplicatedMaterial->id;
        }

        return $this->store($request);
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
}
