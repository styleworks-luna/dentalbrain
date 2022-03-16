<?php

namespace App\Http\Controllers\Admin\Program;

use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Services\Search\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class OnlineStudentController extends OnlineProgramController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  강의 수강 현황
     *
     * @param Request $request
     * @param Program $program
     * @return JsonResponse
     */
    public function students(Request $request, Program $program): JsonResponse
    {
        $order = $request->get('order', 'latest');
        $keyword = $request->get('keyword', null);

        return response()->json([
            'program_name' => $program->title,
            'students' => $this->onlineConcrete
                ->searchStudents($program, $order, $keyword)->paginate(10),
        ]);
    }


    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramStudent $student
     * @return JsonResponse
     */
    public function extend(Request $request, Program $program, ProgramStudent $student): JsonResponse
    {
        $data = $request->validate(['expired_at' => 'required']);
        $expiredAt = Carbon::make($data['expired_at'] ?? null);

        $student->expired_at = $expiredAt;
        $student->save();

        return response()->json([
            'expired_at' => $expiredAt->toDateTimeLocalString()
        ]);
    }
}
