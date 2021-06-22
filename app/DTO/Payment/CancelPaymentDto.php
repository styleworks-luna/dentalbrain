<?php


namespace App\DTO\Payment;


use App\Models\Membership\Membership;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CancelPaymentDto
{
    private $data;

    private $reason;

    private $bank;
    private $accountNumber;
    private $holderName;

    private function __construct($reason, $bank = null, $accountNumber = null, $holderName = null, Request $request = null)
    {
        $this->reason = $reason;
        $this->bank = $bank;
        $this->accountNumber = $accountNumber;
        $this->holderName = $holderName;
        if ($request != null) {
            $this->data = $request->all();
        } else {
            $this->data = [
                'reason' => $this->reason,
                'bank' => $this->bank,
                'accountNumber' => $this->accountNumber,
                'holderName' => $this->holderName,
            ];
        }
    }

    /**
     * @param Request $request
     * @param Program $program
     * @param User $user
     * @return CancelPaymentDto|null
     */
    public static function createWhenProgramCancelAdmin(Request $request, Program $program, User $user): ?CancelPaymentDto
    {
        $student = self::validateAndGetStudent($program, $user);
        if ($student == null) {
            return null;
        }

        return self::getProgramCancelInstance($request, $program, $student);
    }

    /**
     * @param $program
     * @param Authenticatable| User $user
     * @return ProgramStudent|null
     */
    private static function validateAndGetStudent($program, $user): ?ProgramStudent
    {
        $student = $program->students()
            ->where('user_id', '=', $user->id)
            ->whereIn('pay_status', ProgramStudent::$USER_CANCEL_AVAILABLE_STATUSES);

        if ($student->count() > 1) {
            Log::error('CANCEL ERROR, 한 개보다 많습니다.');
            return null;
        }

        return $student->first();
    }

    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramStudent $student
     * @return CancelPaymentDto|null
     */
    private static function getProgramCancelInstance(Request $request, Program $program, ProgramStudent $student): ?CancelPaymentDto
    {
        if ($program->getUserSpecificFree(Auth::user())) {
            return new CancelPaymentDto('무료 강의 취소 신청');
        }

        if ($student->pay_status == ProgramStudent::$PAY_ANOTHER_PAID
            || $student->pay_status == ProgramStudent::$PAY_ANOTHER_IN_PROCESS) {
            // 별도 결제의 경우 reason 및 다른 params 필요없음
            // 더미 값
            return new CancelPaymentDto('별도 결제 취소 신청');

        }

        return self::validateAndGetInstancePaidByToss($request, $student->payment);
    }

    private static function validateAndGetInstancePaidByToss(Request $request, $payment): ?CancelPaymentDto
    {
        $v = Validator::make($request->all(), [
            'reason' => ['required', 'string'],
        ])->sometimes(
        // 가상계좌의 경우, 은행, 예금주, 계좌번호가 필요함.
            ['bank', 'accountNumber', 'holderName'],
            ['required', 'string'],
            function ($input) use ($payment) {
                return $payment->method == '가상계좌';
            });

        if ($v->fails()) {
            Log::debug('VALIDATE INFO', $v->failed());
            return null;
        }

        $data = $v->validated();

        return new CancelPaymentDto(
            $data['reason'],
            $data['bank'] ?? null,
            $data['accountNumber'] ?? null,
            $data['holderName'] ?? null
        );
    }

    /**
     * @param Request $request
     * @param Program $program
     * @return CancelPaymentDto|null
     */
    public static function createWhenProgramCancelUser(Request $request, Program $program): ?CancelPaymentDto
    {
        $student = self::validateAndGetStudent($program, Auth::user());
        if ($student == null) {
            return null;
        }

        if (!$student->cancelAvailable()) {
            Log::error('STUDENT CANNOT CANCEL PROGRAM', [$program]);
            return null;
        }

        return self::getProgramCancelInstance($request, $program, $student);
    }

    /**
     * @param Request $request
     * @param Membership $membership
     * @return CancelPaymentDto|null
     */
    public static function createWhenMembershipCancelAdmin(Request $request, Membership $membership): ?CancelPaymentDto
    {
        if (!in_array($membership->pay_status, Membership::$USER_CANCEL_AVAILABLE_STATUSES)) {
            Log::error('취소할수 있는 결제상태가 아닙니다.');
            return null;
        }

        return self::getMembershipCancelInstance($request, $membership);
    }

    private static function getMembershipCancelInstance(Request $request, Membership $membership): ?CancelPaymentDto
    {
        if ($membership->pay_status == Membership::$PAY_ANOTHER_PAID
            || $membership->pay_status == Membership::$PAY_ANOTHER_IN_PROCESS) {
            // 별도 결제의 경우 reason 및 다른 params 필요없음
            // 더미 값
            return new CancelPaymentDto('별도 결제 취소 신청');
        }

        if ($membership->pay_status == Membership::$PAY_PAID && $membership->payment == null) {
            return new CancelPaymentDto('관리자가 생성한 유료회원 취소 신청');
        }

        return self::validateAndGetInstancePaidByToss($request, $membership);
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @return mixed|null
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @return mixed|null
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @return mixed|null
     */
    public function getHolderName()
    {
        return $this->holderName;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
