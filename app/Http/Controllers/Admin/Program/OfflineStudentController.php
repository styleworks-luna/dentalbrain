<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\Program;

class OfflineStudentController extends OfflineProgramController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function students(Program $program)
    {
        return response()->json(
            $this->offlineConcrete->getStudents($program)
        );
    }
}
