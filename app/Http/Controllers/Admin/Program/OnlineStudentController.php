<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use Illuminate\Http\Request;

class OnlineStudentController extends OnlineProgramController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function students(Program $program)
    {
        return response()->json([
            'program_name' => $program->title,
            'students' => $this->onlineConcrete->getStudents($program)
        ]);
    }

    public function cancel(Request $request, Program $program, ProgramStudent $student)
    {
        $validatedData = $this->onlineConcrete->validateAdminCancel($request, $program, User::find($student->user_id));
        if ($validatedData) {
            $response = $this->onlineConcrete->cancel($program, $student, $validatedData);
        } else {
            return response()->json(['message' => '유효하지 않은 요청입니다.'], 422);
        }

        if ($response === false) {
            return response()->json(['message' => '취소 오류 발생 하였습니다.'], 500);
        }
        return response()->json(['message' => '취소되었습니다.']);
    }
}
