<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Mail\ApplyLecture;
use App\Models\Certificate\CertificateCompletion;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\File;
use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\Survey;
use App\Services\Certificate\CertificateService;
use App\Services\File\CertificateThumbnail;
use App\Services\Program\OfflineProgramConcrete;
use App\Services\Program\OnlineProgramConcrete;
use App\Services\Survey\SurveyAnswerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApplyController extends Controller
{
    protected $certificateService;

    /**
     * @param CertificateService $certificateService
     */
    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    public function showApplyForm(Program $program)
    {
        if ($program->alreadyApplied() || $program->waitDeposit() || $program->waitConfirmAnotherPay()) {
            // 이미 신청 완료하여 결제프로세스까지 마친 경우
            return redirect()->route('lectures.result', $program->id);
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

        /** @var ProgramStudent $student */
        $student = $program->students()->where('user_id', '=', Auth::id())->first();
        $user = Auth::user();

        // 가격 산출
        $price = $program->getUserSpecificPrice($user);

        $programDetail = $programService->getProgramDetail($program);

        return view(viewPrefix() . 'pages.lecture.lecture_apply', [
            'program' => $programDetail['program'],
            'surveys' => $programDetail['surveys'],
            'student' => $student,
            'user' => $user,
            'price' => $price,
        ]);
    }

    /**
     *  재수강 시에 질문을 새로 작성하지 않음.
     *
     * @param Request $request
     * @param Program $program
     * @return RedirectResponse
     */
    public function apply(Request $request, Program $program): RedirectResponse
    {

        // 자격증 여부 추가 신청 validate
        if ($program->completion_id || $program->qualification_id) {
            $profileData = $this->certificateService->getValidatorRecruit($request, []);
        }

        // 파일을 함께 조회하기 위해 all 사용.
        $surveyDataSet = $request->all('surveys')['surveys'];
        $surveyAnswerService = new SurveyAnswerService();

        try {
            DB::beginTransaction();

            if ($program->surveys()->exists()) {
                // 질문이 존재하는 경우
                if (!$surveyAnswerService->validateSurveyAnswers($surveyDataSet)) {
                    // Validation Failed.

                    DB::rollback();
                    return redirect()->back(302)->with(['alert' => '필수 입력란을 작성해주세요.']);
                }
                $surveyAnswerService->deleteSurveyAnswersOfUser($program, Auth::user());
                $surveyAnswerService->storeSurveyAnswers($surveyDataSet);
            }

            $price = $program->getUserSpecificPrice();
            $programStudent = ProgramStudent::updateOrCreateWhenApplySuccess($program, $price);

            // 파일 생성
            $file = CertificateThumbnail::saveFile($profileData['file']);
            // 수료/자격증 증명정보 생성
            if ($program->qualification_id) {
                $this->certificateService->storeQualificationProfile($profileData, $program, $file);
            }
            if ($program->completion_id) {
                $this->certificateService->storeCompletionProfile($profileData, $program, $file);
            }

            DB::commit();
            if ($price == 0) {
                // 무료 행사인 경우.
                Mail::to(Auth::user()->email)->send(new ApplyLecture(Auth::user(), $programStudent));
                Mail::to(config('mail.admin_emails', ['dentalbrainon@gmail.com']))->send(new ApplyLecture(Auth::user(), $programStudent));

                // 신청 후 => 증명정보 상태 '대기'로 변경
                $this->certificateService->updateCertificationProfilesLoginUser($program);

                return redirect()->route('lectures.result', $program->id);
            }

            return redirect()->route('lectures.payment.form', $program)->with(['fromApply' => true]);

        } catch (\Exception $exception) {
            Log::error('STORE SURVEY ANSWER ERROR', [$exception]);

            DB::rollback();
            return redirect()->back()->with(['alert' => '오류가 발생했습니다']);
        }
    }

    public function anotherPay(Program $program)
    {
        $programStudent = ProgramStudent::updateWhenAnotherPayProcess($program);

        /** @var ProgramStudent $programStudent */
        $payment = Payment::createWhenAnotherPayProcess($program, $programStudent);

        $programStudent->payment_id = $payment->id;

        $programStudent->save();

        return $this->result($program);
    }

    public function result(Program $program)
    {
        $surveys = Survey::result($program->id)
            ->get();

        /** @var ProgramStudent $programStudent */
        $programStudent = ProgramStudent::query()->where('program_id', '=', $program->id)
            ->where('user_id', '=', Auth::id())
            ->first();
        $programStudent->with('payment');

        return view(viewPrefix() . 'pages.lecture.lecture_result', [
            'program' => $program,
            'surveys' => $surveys,
            'programStudent' => $programStudent,
            'user' => Auth::user(),
        ]);
    }
}
