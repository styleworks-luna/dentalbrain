<?php


namespace App\Services\Program;


use App\DTO\Payment\CancelPaymentDto;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use App\Services\Payment\PaymentService;
use App\Services\Payment\TossPaymentsService;
use App\Services\Survey\SurveyAnswerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

abstract class ProgramCancelTemplate extends ProgramTemplate
{

    /**
     * @param Program $program
     * @return OfflineProgramCancelConcrete|OnlineProgramCancelConcrete
     */
    public static function getProgramCancelConcrete(Program $program)
    {
        if ($program->is_online) {
            return new OnlineProgramCancelConcrete();
        } else {
            return new OfflineProgramCancelConcrete();
        }
    }

    /**
     *  범용적 삭제 플로우
     *
     * @param Program $program
     * @param ProgramStudent $student
     * @param CancelPaymentDto $dto
     * @return boolean
     */
    public function cancel(Program $program, ProgramStudent $student, CancelPaymentDto $dto): bool
    {
        try {
            DB::beginTransaction();

            // 질문 답변 삭제 진행
            SurveyAnswerService::deleteSurveyAnswersOfUser($program, $student->user);

            // 결제 취소 진행.
            if ($student->payment()->exists()) {
                TossPaymentsService::cancelPaid($student->payment, $student->pay_status, $dto);
            }

            $student->updateWhenCancel($program->getUserSpecificFree($student->user));

            DB::commit();
            return true;

        } catch (Exception $exception) {
            Log::error('CANCEL ERROR', [$exception]);
            DB::rollBack();
            return false;
        }

    }

    /**
     *  관리자 에서 환불 했을시, validate
     *
     * @param Request $request
     * @param Program $program
     * @param User $user
     * @return CancelPaymentDto|null validated data
     */
    public function validateAdminCancel(Request $request, Program $program, User $user): ?CancelPaymentDto
    {
        return CancelPaymentDto::createWhenProgramCancelAdmin($request, $program, $user);
    }

    /**
     *  유저의 자동환불 요청 validation 하는 함수.
     *
     * @param Request $request
     * @param Program $program
     * @return CancelPaymentDto|null validated data, 실패시 false 리턴함.
     */
    public function validateUserCancel(Request $request, Program $program): ?CancelPaymentDto
    {
        return CancelPaymentDto::createWhenProgramCancelUser($request, $program);
    }

    /**
     *  오프라인 환불 요청
     *
     * @param Request $request
     * @param Program $program
     * @return array|false|string[]
     */
    public function validateUserRequestCancel(Request $request, Program $program)
    {
        if ($program->is_online == 1) {
            return false;
        }

        $base = $program->students()
            ->where('user_id', '=', Auth::id())
            ->where('pay_status', '=', ProgramStudent::$PAY_PAID);
        if ($base->count() > 1) {
            Log::error('CANCEL ERROR, 한 개보다 많습니다.');
            return false;
        }

        $student = $base->first();

        if (!$program->canRequestRefund()) {
            return false;
        }

        if ($program->is_free) {
            return ['reason' => '무료 강의 취소 신청'];
        } else {
            $v = Validator::make($request->all(), [
                'reason' => ['required', 'string'],
            ])->sometimes(
            // 가상계좌의 경우, 은행, 예금주, 계좌번호가 필요함.
                ['bank', 'accountNumber', 'holderName'],
                ['required', 'string'],
                function ($input) use ($student) {
                    return $student->payment->method == '가상계좌';
                });

            return $v->validated();
        }
    }

    public function revert(Program $program, ProgramStudent $student): bool
    {
        $student->revert();
        $student->payment->revert();

        return true;
    }
}
