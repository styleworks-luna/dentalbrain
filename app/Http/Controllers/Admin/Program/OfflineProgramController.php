<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\File;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Services\File\ProgramThumbnail;
use App\Services\Program\OfflineProgramConcrete;
use App\Services\Search\SearchService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class OfflineProgramController extends BaseProgramController implements ProgramControllerInterface
{
    protected $offlineConcrete;

    public function __construct()
    {
        $this->offlineConcrete = new OfflineProgramConcrete();
    }

    public function search(Request $request)
    {
        $query = Program::query()
            ->with('certificateQualification:id,title', 'certificateCompletion:id,title')
            ->withCount(['completionProfiles as completion_count' => function (Builder $query) {
                $query->where('status', '!=', CompletionProfile::$DO_NOT_PAID);
            }])
            ->withCount(['qualificationProfiles as qualification_count' => function (Builder $query) {
                $query->where('status', '!=', QualificationProfile::$DO_NOT_PAID);
            }]);

        $this->search = new SearchService($query);

        $this->search->addKeyword('title', $request->keyword);
        $this->addMajorCategoryId($request);
        $this->addMinorCategoryId($request);

        return $this->search->search()
            ->where('is_online', '=', 0)
            ->with('place:id,program_id,started_at,ended_at,address,address_detail')
            ->withCount(['students' => function ($query) {
                $query->where('pay_status', '!=', ProgramStudent::$PAY_BEFORE)
                    ->where('pay_status', '!=', ProgramStudent::$PAY_REFUNDED);
            }])->orderByDesc('id')
            ->paginate(10);
    }

    public function update(Request $request, Program $program)
    {
        $programData = $this->offlineConcrete->validateUpdateProgram($request);
        $surveyDataSet = $this->offlineConcrete->validateUpdateSurveys($request);
        $placeData = $this->offlineConcrete->validateUpdatePlace($request);

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
        $programData = $this->offlineConcrete->validateStoreProgram($request);
        $surveyDataSet = $this->offlineConcrete->validateStoreSurveys($request);
        $placeData = $this->offlineConcrete->validateStorePlace($request);

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
