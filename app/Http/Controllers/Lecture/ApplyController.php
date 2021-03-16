<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Mail\ApplyLecture;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\Survey;
use App\Services\Program\OfflineProgramConcrete;
use App\Services\Program\OnlineProgramConcrete;
use App\Services\Survey\SurveyAnswerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ApplyController extends Controller
{
    public function showApplyForm(Program $program)
    {
        if ($program->alreadyApplied() || $program->waitDeposit()) {
            // 이미 신청 완료하여 결제프로세스까지 마친 경우
            return redirect()->route('lectures.result', $program->id);
        }

        if ($program->answers()->where('user_id', '=', Auth::id())->exists()) {
            $student = ProgramStudent::query()->where('ticket_id',$program->ticket()->first()->id)->where('user_id','=',Auth::id())->first();
            // Survey 이미 완료하였을 경우.
            $programStudent = ProgramStudent::updateOrCreateWhenApplySuccess($program,
                $student->email,
                $student->phone
            );
            return redirect()->route('lectures.payment.form', $program->id)->with(['fromApply' => true]);
        }


        if ($program->is_online == 1) {
            // 온라인 강의
            $programService = new OnlineProgramConcrete();
        } else {
            // 오프라인 강의
            if ($program->exceedCapacity()) {
                // 강의 정원보다 수강생이 많을 경우
                return redirect()->back()->with('alert', '모집정원이 마감되었습니다.');
            }
            $programService = new OfflineProgramConcrete();
        }

        $student = $program->students()->where('user_id', '=', Auth::id())->first();

        $programDetail = $programService->getProgramDetail($program);

        return view(viewPrefix() . 'pages.lecture.lecture_apply', [
            'program' => $programDetail['program'],
            'surveys' => $programDetail['surveys'],
            'student' => $student,
        ]);
    }

    /**
     *  재수강 시에 질문을 새로 작성하지 않음.
     *
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Http\RedirectResponse
     */
    public function apply(Request $request, Program $program)
    {
        // 파일을 함께 조회하기 위해 all 사용.
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

                $surveyAnswerService->storeSurveyAnswers($surveyDataSet);
            }

            $programStudent = ProgramStudent::updateOrCreateWhenApplySuccess($program, $request->get('email'), $request->get('phone'));

            if ($program->ticket->is_free) {
                // 무료 행사인 경우.
                DB::commit();

                Mail::to($request->get('email'))->send(new ApplyLecture(Auth::user(), $programStudent));
                Mail::to(config('mail.admin_emails', ['dentalbrainon@gmail.com']))->send(new ApplyLecture(Auth::user(), $programStudent));

                return redirect()->route('lectures.result', $program->id);
            }

            DB::commit();
            return redirect()->route('lectures.payment.form', $program)->with(['fromApply' => true]);

        } catch (\Exception $exception) {
            Log::error('STORE SURVEY ANSWER ERROR', [$exception]);

            DB::rollback();
            return redirect()->back(302)->with(['alert' => '오류가 발생했습니다']);
        }
    }

    public function result(Program $program)
    {
        $surveys = Survey::result($program->id)
            ->get();

        $programStudent = ProgramStudent::query()->where('ticket_id', '=', $program->ticket->id)
            ->where('user_id', '=', Auth::id())
            ->first();

        return view(viewPrefix() . 'pages.lecture.lecture_result', [
            'program' => $program,
            'surveys' => $surveys,
            'programStudent' => $programStudent,
        ]);
    }
}
