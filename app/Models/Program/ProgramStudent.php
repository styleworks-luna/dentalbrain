<?php

namespace App\Models\Program;

use App\Models\Payments\Payment;
use App\Models\User;
use App\Payments\TossPayments\TossPaymentsResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProgramStudent extends Model
{
    use SoftDeletes;

    /**
     * 결제 아직 안했을 경우
     * @var int
     */
    static $PAY_BEFORE = 0;
    /**
     *  가상계좌 결제 진행중
     * @var int
     */
    static $PAY_IN_PROCESS = 1;
    /**
     * 결제 완료
     * @var int
     */
    static $PAY_PAID = 2;
    /**
     * 환불 완료
     * @var int
     */
    static $PAY_REFUNDED = 3;
    /**
     * 환불 요청됨
     * @var int
     */
    static $PAY_IN_REFUND_PROCESS = 4;

    /**
     * 별도 결제
     * @var int
     */
    static $PAY_ANOTHER_IN_PROCESS = 5;

    /**
     * 별도 결제
     * @var int
     */
    static $PAY_ANOTHER_PAID = 6;


    protected $appends = ['left_days'];
    protected $guarded = [];
    protected $casts = [
        'is_repeated' => 'boolean',
        'applied_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public static function updateWhenAnotherPayProcess(Program $program)
    {
        $programStudent = ProgramStudent::query()
            ->where('program_id', '=', $program->id)
            ->where('user_id', '=', Auth::id())
            ->first();
        $programStudent->pay_status = ProgramStudent::$PAY_ANOTHER_IN_PROCESS;
        $programStudent->save();

        return $programStudent;
    }

    /**
     *  토스 결제 승인 시에 업데이트 하는 쿼리
     *
     * @param TossPaymentsResponse $response
     * @param Program $program
     * @param Payment $payment
     * @return ProgramStudent|Model
     */
    public static function updateWhenTossSuccess(TossPaymentsResponse $response, Program $program, Payment $payment)
    {
        $programStudent = ProgramStudent::query()->where('user_id', '=', Auth::id())
            ->where('program_id', '=', $program->id)->first();
        if ($response->isCard() || $response->isTransfer()) {
            $programStudent->update([
                'payment_id' => $payment->id,
                'expired_at' => $program->is_online ? now()->addDays($program->term) : $program->place->ended_at,
                'pay_status' => ProgramStudent::$PAY_PAID,
            ]);
        } elseif ($response->isVirtualAccount()) {
            $programStudent->update([
                'payment_id' => $payment->id,
                'pay_status' => ProgramStudent::$PAY_IN_PROCESS,
            ]);
        }
        $programStudent->refresh();

        return $programStudent;
    }

    /**
     *  신청 성공 시에 업데이트 하는 쿼리
     *
     * @param Program $program
     * @return ProgramStudent
     */
    public static function updateOrCreateWhenApplySuccess(Program $program)
    {
        if ($program->is_free) {
            return ProgramStudent::updateOrCreate([
                'program_id' => $program->id,
                'user_id' => Auth::id(),
            ], [
                'program_id' => $program->id,
                'user_id' => Auth::id(),
                'applied_at' => now(),
                'expired_at' => $program->is_online ? now()->addDays($program->term) : $program->place->ended_at,
                'pay_status' => ProgramStudent::$PAY_PAID,
                'is_repeated' => $program->canRepeat(),
            ]);
        } else {
            return ProgramStudent::updateOrCreate([
                'program_id' => $program->id,
                'user_id' => Auth::id(),
            ], [
                'program_id' => $program->id,
                'user_id' => Auth::id(),
                'applied_at' => now(),
                'is_repeated' => $program->canRepeat(),
            ]);
        }
    }

    /**
     *  별도 결제 어드민 확인시.
     *
     * @param Program $program
     * @param $expired_at
     * @return bool
     */
    public function updateWhenConfirmAnotherPay(Program $program, $expired_at): bool
    {
        return $this->update([
            'pay_status' => self::$PAY_ANOTHER_PAID,
            'expired_at' => $expired_at,
            'is_watched' => 1,
        ]);
    }

    public function updateWhenCancel($is_free): bool
    {
        return $this->update([
            'pay_status' => $is_free ? ProgramStudent::$PAY_BEFORE : ProgramStudent::$PAY_REFUNDED,
            'is_watched' => 0,
            'expired_at' => null,
        ]);
    }

    public function revert() {
        return $this->update([
            'pay_status' => ProgramStudent::$PAY_ANOTHER_IN_PROCESS,
            'is_watched' => 0,
            'expired_at' => null,
        ]);
    }

    /**
     *  환불 가능 상태인지 체크.
     *
     * @return bool
     */
    public function cancelAvailable()
    {
        if ($this->attributes['pay_status'] != self::$PAY_PAID
            && $this->attributes['pay_status'] != self::$PAY_ANOTHER_PAID) {
            return false;
        }

        /*
        * if ($program->is_online) {
        *  # 온라인 강의
        *      1. 7일 내
        *      2. 강의 미 시청시. ( is_watched == 0 )
        * } else {
        *  # 오프라인 강의
        *      1. 2일 > 남은 날짜
         *     2. 남은 날짜 > 1일
        * }
        */

        if ($this->program->is_online) {
            if (
                strtotime($this->attributes['applied_at']) > now()->subDays(7)->unix()
                && $this->attributes['is_watched'] == 0
            ) {
                return true;
            } else {
                return false;
            }
        } else {
            if (
                strtotime($this->attributes['expired_at']) > now()->addDays(2)->unix()
            ) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
     * ====================================== Relations ===============================
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function getLeftDaysAttribute()
    {
        if (isset($this->attributes['expired_at'])) {
            return Carbon::now()->diff($this->attributes['expired_at'])->format('%r%a');
        } else {
            return null;
        }
    }

    /**
     * 결제해야하는 금액 받음.
     *
     * @return string
     */
    public function getPrice()
    {
        if (
            ($this->attributes['expired_at'] < now() && $this->attributes['pay_status'] == self::$PAY_PAID)
            || $this->attributes['is_repeated'] == true
        ) {
            return $this->program->repeat_price;
        }
        return $this->program->price;
    }
}
