<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Traits\ProgramFunctions;

class OnlineProgramController extends Controller
{
    use ProgramFunctions;

    public function index()
    {
        return $this->programIndex(1);
    }

    public function students(Program $program)
    {
        return $this->getStudentInfo($program);
    }

}
