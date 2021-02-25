<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Mail\ApplyLecture;
use App\Mail\ApplyOfflineLecture;
use App\Mail\ApplyOnlineLecture;
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
        if ($program->alreadyPaid()) {
            // 이미 신청 완료하여 결제프로세스까지 마친 경우
            return redirect()->route('lectures.result', $program->id);
        }

        if ($program->answers()->where('user_id', '=', Auth::id())->exists()) {
            // Survey 이미 완료하였을 경우.
            return redirect()->route('lectures.payment.form', $program->id)->with(['fromApply' => true]);
        }

        if ($program->is_online == 1) {
            $programService = new OnlineProgramConcrete();
        } else {
            $programService = new OfflineProgramConcrete();
        }

        $programDetail = $programService->getProgramDetail($program);

        return view(viewPrefix() . 'pages.lecture.lecture_apply', [
            'program' => $programDetail['program'],
            'surveys' => $programDetail['surveys']
        ]);
    }

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

            ProgramStudent::updateOrCreateWhenApplySuccess($program, $request->get('email'), $request->get('phone'));

            if ($program->ticket->is_free) {
                // 무료 행사인 경우.
                DB::commit();
                $this->sendLectureApplyFreeMailWithIsOnline($request, $program);

                return redirect()->route('lectures.result', $program->id);
            }

            DB::commit();
            return redirect()->route('lectures.payment.form', $program)->with(['fromApply' => true]);

        } catch (\Exception $exception) {
            Log::error('STORE SURVEY ANSWER ERROR', [$exception]);
            
            DB::rollback();
            return redirect()->back(302)->with(['alert' => '오류']);
        }
    }

    private function sendLectureApplyFreeMailWithIsOnline(Request $request, Program $program)
    {
        Mail::to($request->get('email'))->send(new ApplyLecture(Auth::user(), $this->programQueryWithPlaceAndTicket($program)));
    }

    private function programQueryWithPlaceAndTicket(Program $program)
    {
        return ProgramStudent::query()
            ->select('id','user_id','ticket_id','created_at','expired_at')
            ->where('user_id',Auth::id())
            ->with('ticket:id,program_id','ticket.program:id,title')
            ->whereHas('ticket.program',function($query) use ($program){
                $query->where('id',$program->id);
            })->get();
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
