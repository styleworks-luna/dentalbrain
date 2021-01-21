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
        $data = $this->onlineConcrete->validate($request);
        $lectureDataSet = $this->onlineConcrete->validateLectures($request);

        $program = $this->onlineConcrete->storeProgram($data);
        $lectures = $this->onlineConcrete->storeLectures($lectureDataSet);

    }

    function additionalValidate(Request $request)
    {
        // 추가적으로 validation 필요한 것들.
        return [];
    }
}
