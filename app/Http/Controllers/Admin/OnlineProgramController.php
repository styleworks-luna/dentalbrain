<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Services\Program\OnlineProgramConcrete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OnlineProgramController extends Controller
{
    protected $onlineConcrete;

    public function __construct()
    {
        $this->onlineConcrete = new OnlineProgramConcrete();
    }

    public function index()
    {
        return $this->onlineConcrete->getPrograms();
    }

    public function students(Program $program)
    {
        return $this->onlineConcrete->getStudents($program);
    }

    public function store(Request $request)
    {
        $programData = $this->onlineConcrete->validateProgram($request);
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

    function additionalValidate(Request $request)
    {
        // 추가적으로 validation 필요한 것들.
        return [];
    }

    public function getCategories()
    {
        return $this->onlineConcrete->getCategories();
    }
}
