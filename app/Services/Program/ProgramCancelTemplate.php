<?php


namespace App\Services\Program;


use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\SurveyCategory;
use App\Models\User;
use App\Payments\TossPayments\TossPayments;
use App\Services\File\SurveyFile;
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
     * @param array $validatedData
     * @return boolean
     */
    public function cancel(Program $program, ProgramStudent $student, array $validatedData = []): bool
    {
        try {
            DB::beginTransaction();

            // 질문 답변 삭제 진행
            $builderOfSurveyAnswers = $program->answers()->where('user_id', '=', $student->user_id);

            //질문 답변 - 파일 삭제
            $surveyFiles = $builderOfSurveyAnswers->where('category_id', '=', SurveyCategory::$FILE)
                ->get()->mapInto(SurveyFile::class);

            $surveyFiles->map(function ($item, $key) {
                return $item->deleteFile();
            });

            $program->answers()->where('user_id', '=', $student->user_id)->delete();

            // 결제 취소 진행.
            if ($student->payment()->exists()) {
                if ($student->pay_status == ProgramStudent::$PAY_PAID) {
                    // PG 사 통한 결제
                    $payment = $student->payment;
                    $tossPayment = new TossPayments($payment->paymentKey);
                    switch ($payment->method) {
                        case '계좌이체':
                            $response = $tossPayment->cancelTransfer($validatedData['reason']);
                            break;
                        case '카드':
                            $response = $tossPayment->cancelCard($validatedData['reason']);
                            break;
                        case '가상계좌':
                            $response = $tossPayment->cancelVirtualAccount(
                                $validatedData['reason'], $validatedData['bank'], $validatedData['accountNumber'], $validatedData['holderName']
                            );
                            break;
                        //case '휴대폰':
                        default:
                            $response = false;
                            Log::error('INVALID METHOD', $validatedData);
                            break;
                    }
                    if ($response === false) {
                        DB::rollBack();
                        return false;
                    }

                    $payment->updateByToss($response);

                } elseif ($student->pay_status == ProgramStudent::$PAY_ANOTHER_IN_PROCESS) {
                    /** @var Payment $payment */
                    $payment = $student->payment;
                    $payment->cancelAnotherPay();
                }
            }

            $student->updateWhenCancel($program->ticket->is_free);

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
     * @return array|false validated data
     */
    public function validateAdminCancel(Request $request, Program $program, User $user)
    {
        $base = $program->students()
            ->where('user_id', '=', $user->id)
            ->whereIn('pay_status', [
                ProgramStudent::$PAY_PAID, ProgramStudent::$PAY_IN_REFUND_PROCESS,
                ProgramStudent::$PAY_ANOTHER_IN_PROCESS, ProgramStudent::$PAY_ANOTHER_PAID
            ]);
        if ($base->count() > 1) {
            Log::error('CANCEL ERROR, 한 개보다 많습니다.');
            return false;
        }

        $student = $base->first();

        if ($program->ticket->is_free) {
            // 무료의 경우 reason 및 다른 params 필요없음
            // 더미 값.
            return ['reason' => '무료 강의 취소'];
        }

        if ($student->pay_status == ProgramStudent::$PAY_ANOTHER_PAID
            || $student->pay_status == ProgramStudent::$PAY_ANOTHER_IN_PROCESS) {
            // 별도 결제의 경우 reason 및 다른 params 필요없음
            // 더미 값
            return ['reason' => '별도 결제 취소'];
        }

        $v = Validator::make($request->all(), [
            'reason' => ['required', 'string'],
        ])->sometimes(
        // 가상계좌의 경우, 은행, 예금주, 계좌번호가 필요함.
            ['bank', 'accountNumber', 'holderName'],
            ['required', 'string'],
            function ($input) use ($student) {
                return $student->payment->method == '가상계좌';
            });

        if ($v->fails()) {
            Log::debug('VALIDATE INFO', $v->failed());
            return false;
        }

        return $v->validated();
    }

    /**
     *  유저의 자동환불 요청 validation 하는 함수.
     *
     * @param Request $request
     * @param Program $program
     * @return array|false validated data, 실패시 false 리턴함.
     */
    public function validateUserCancel(Request $request, Program $program)
    {
        $base = $program->students()
            ->where('user_id', '=', Auth::id())
            ->where('pay_status', '=', ProgramStudent::$PAY_PAID);
        if ($base->count() > 1) {
            Log::error('CANCEL ERROR, 한 개보다 많습니다.');
            return false;
        }

        $student = $base->first();

        if (!$student->cancelAvailable()) {
            return false;
        }

        if ($program->ticket->is_free) {
            return ['reason' => '무료 강의 취소 신청'];
        }

        if ($student->pay_status == ProgramStudent::$PAY_ANOTHER_PAID
            || $student->pay_status == ProgramStudent::$PAY_ANOTHER_IN_PROCESS) {
            // 별도 결제의 경우 reason 및 다른 params 필요없음
            // 더미 값
            return ['reason' => '별도 결제 취소'];
        }

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

        if ($program->ticket->is_free) {
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
}
