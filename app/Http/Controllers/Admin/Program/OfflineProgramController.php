<?php

namespace App\Http\Controllers\Admin\Program;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Services\File\ProgramThumbnail;
use App\Services\Program\OfflineProgramConcrete;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class OfflineProgramController extends BaseProgramController implements ProgramControllerInterface
{
    protected $offlineConcrete;
    /**
     * @var SearchService|null
     */
    
    public function __construct()
    {
        $this->offlineConcrete = new OfflineProgramConcrete();
    }

    public function search(Request $request)
    {
        $this->search = new SearchService(Program::query());

        $this->search->addKeyword('title', $request->keyword);
        $this->addMajorCategoryId($request);
        $this->addMinorCategoryId($request);

        $search = $this->search->search()->where('is_online', '=', $this->offlineConcrete->is_online)
            ->with('place:id,program_id,started_at,ended_at,address,address_detail')
            ->withCount(['students' => function ($query) {
                $query->where('pay_status', '!=', ProgramStudent::$PAY_BEFORE)
                    ->where('pay_status', '!=', ProgramStudent::$PAY_REFUNDED);
            }])->orderByDesc('id')->paginate('10');

        return $search;
    }

    public function update(Request $request, Program $program)
    {
        $programData = $this->offlineConcrete->validateProgram($request);
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
            $this->offlineConcrete->updateSurveys($program, $surveyDataSet);
            $this->offlineConcrete->updatePlace($program, $placeData);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ONLINE PROGRAM STORE ERROR',
                [$exception, $programData, $surveyDataSet]);
            return response()->json([
                'msg' => '오류가 발생했습니다.',
            ], 500);
        }
        DB::commit();

        return response()->json([
            'msg' => '오프라인 강의가 수정되었습니다.',
        ]);
    }

    public function duplicateEdit(Program $program)
    {
        return $this->edit($program);
    }

    public function edit(Program $program)
    {
        return response()->json(
            array_merge($this->offlineConcrete->getProgramDetail($program), [
                'place' => $program->place,
                'haveStudents' => $program->students()->exists()
            ])
        );
    }

    public function duplicate(Request $request, Program $program)
    {
        $duplicatedThumbnail = ProgramThumbnail::duplicate(File::find($request['thumbnail_id']));
        $request['thumbnail_id'] = $duplicatedThumbnail->id;
        return $this->store($request);
    }

    public function store(Request $request)
    {
        $programData = $this->offlineConcrete->validateProgram($request);
        $surveyDataSet = $this->offlineConcrete->validateSurveys($request);
        $placeData = $this->offlineConcrete->validatePlace($request);

        try {
            DB::beginTransaction();
            $program = $this->offlineConcrete->storeProgram($programData);
            $this->offlineConcrete->storeSurveys($program, $surveyDataSet);
            $this->offlineConcrete->storePlace($program, $placeData);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ONLINE PROGRAM STORE ERROR',
                [$exception, $programData, $surveyDataSet]);
            return response()->json([
                'msg' => '오류가 발생했습니다.',
            ], 500);
        }
        DB::commit();

        return response()->json([
            'msg' => '오프라인 강의가 생성되었습니다.',
        ]);
    }
}
