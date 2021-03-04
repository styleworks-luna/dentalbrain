<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfflineStudentController extends OfflineProgramController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 강의 수강 현황
     *
     * @param Program $program
     * @return JsonResponse
     */
    public function students(Program $program)
    {
        return response()->json([
            'program_name' => $program->title,
            'students' => $this->offlineConcrete->getStudents($program)
        ]);
    }

    /**
     * 어드민 환불 처리
     *
     * @param Request $request
     * @param Program $program
     * @param ProgramStudent $student
     * @return JsonResponse
     * @see OnlineStudentController @cancel
     */
    public function cancel(Request $request, Program $program, ProgramStudent $student)
    {
        $validatedData = $this->offlineConcrete->validateAdminCancel($request, $program, User::find($student->user_id));
        if ($validatedData) {
            $response = $this->offlineConcrete->cancel($program, $student, $validatedData);
        } else {
            return response()->json(['message' => '유효하지 않은 요청입니다.'], 422);
        }

        if ($response === false) {
            return response()->json(['message' => '취소 오류 발생 하였습니다.'], 500);
        }
        return response()->json(['message' => '취소되었습니다.']);
    }
}
