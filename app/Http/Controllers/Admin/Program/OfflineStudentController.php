<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use Illuminate\Http\Request;

class OfflineStudentController extends OfflineProgramController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function students(Program $program)
    {
        return response()->json([
            'program_name' => $program->title,
            'students' => $this->offlineConcrete->getStudents($program)
        ]);
    }

    public function cancel(Request $request, Program $program, ProgramStudent $student)
    {
        $response = $this->offlineConcrete->cancel($request, $program, User::find($student->user_id));
        if ($response === false) {
            return response()->json(['msg' => '실패'], 500);
        }
        return response()->json(['msg' => '성공']);
    }
}
