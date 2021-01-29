<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Services\Program\OfflineProgramConcrete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OfflineProgramController extends Controller
{
    protected $offlineConcrete;

    public function __construct()
    {
        $this->offlineConcrete = new OfflineProgramConcrete();
    }

    public function index()
    {
        return $this->offlineConcrete->getPrograms();
    }

    public function students(Program $program)
    {
        return $this->offlineConcrete->getStudents($program);
    }

    public function edit(Program $program)
    {
        return response()->json(
            array_merge($this->offlineConcrete->getProgramDetail($program),
                ['lectures' => $program->lectures()->with('thumbnail:id,url,name')->get()])
        );
    }

    public function store(Request $request)
    {
        $programData = $this->offlineConcrete->validateProgram($request);
        $ticketData = $this->offlineConcrete->validateTickets($request);
        $surveyDateSet = $this->offlineConcrete->validateSurveys($request);


        try {
            DB::beginTransaction();
            $program = $this->offlineConcrete->storeProgram($programData);
            $ticket = $this->offlineConcrete->storeTickets($program, $ticketData);
            $surveys = $this->offlineConcrete->storeSurveys($program, $surveyDateSet);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ONLINE PROGRAM STORE ERROR',
                [$exception, $programData, $ticketData, $surveyDateSet]);
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
}
