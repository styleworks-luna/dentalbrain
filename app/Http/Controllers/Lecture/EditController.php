<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\Survey;
use App\Services\Survey\SurveyAnswerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditController extends Controller
{
    public function showEditForm(Program $program)
    {
        $surveys = Survey::edit($program->id)
            ->get();

        $programStudent = ProgramStudent::query()->where('ticket_id', '=', $program->ticket->id)
            ->where('user_id', '=', Auth::id())
            ->first();

        return view(viewPrefix() . 'pages.lecture.lecture_edit', [
            'program' => $program,
            'surveys' => $surveys,
            'programStudent' => $programStudent,
        ]);
    }

    public function update(Request $request, Program $program)
    {
        $surveyDataSet = $request->all('surveys')['surveys'];
        $surveyAnswerService = new SurveyAnswerService();
        try {
            DB::beginTransaction();

            if ($program->surveys()->exists()) {
                // 질문이 존재하는 경우
                if ($surveyAnswerService->validateSurveyAnswers($surveyDataSet) == false) {
                    // Validation Failed.

                    DB::rollback();
                    return redirect()->back(302)->with(['alert' => '필수 입력란을 작성해주세요.']);
                }

                $surveyAnswerService->updateSurveyAnswers($surveyDataSet);
            }

            DB::commit();
            return redirect()->route('account.lectures', $program)->with('alert', '수정되었습니다.');

        } catch (\Exception $exception) {
            Log::error('STORE SURVEY ANSWER ERROR', [$exception]);

            DB::rollback();
            return redirect()->back(302)->with(['alert' => '오류가 발생했습니다.']);
        }
    }
}
