<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Services\Program\OnlineProgramConcrete;
use Illuminate\Http\Request;

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

        logger([$programData, $ticketData, $surveyDateSet, $lectureDataSet]);
        ddd();

        $program = $this->onlineConcrete->storeProgram($programData);
        $ticket = $this->onlineConcrete->storeTickets($program, $ticketData);
        $surveys = $this->onlineConcrete->storeSurveys($program, $surveyDateSet);
        $lectures = $this->onlineConcrete->storeLectures($program, $lectureDataSet);

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
