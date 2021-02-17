<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\Program;

class OnlineStudentController extends OnlineProgramController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function students(Program $program)
    {
        return response()->json(
            $this->onlineConcrete->getStudents($program)
        );
    }
}
