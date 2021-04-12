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

    protected $appends = ['left_days'];
    protected $guarded = [];
    protected $casts = [
        'is_repeated' => 'boolean',
        'applied_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    /**
     *  토스 결제 승인 시에 업데이트 하는 쿼리
     *
     * @param TossPaymentsResponse $response
     * @param Program $program
     * @param Payment $payment
     * @return ProgramStudent|Model
     */
    static function updateWhenTossSuccess(TossPaymentsResponse $response, Program $program, Payment $payment)
    {
        $programStudent = ProgramStudent::query()->where('user_id', '=', Auth::id())
            ->where('ticket_id', '=', $program->ticket->id)->first();
        if ($response->isCard() || $response->isTransfer()) {
            $programStudent->update([
                'payment_id' => $payment->id,
                'expired_at' => $program->is_online ? now()->addDays($program->ticket->term) : $program->place->ended_at,
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
    static function updateOrCreateWhenApplySuccess(Program $program)
    {
        if ($program->ticket->is_free) {
            return ProgramStudent::updateOrCreate([
                'ticket_id' => $program->ticket->id,
                'user_id' => Auth::id(),
            ], [
                'ticket_id' => $program->ticket->id,
                'user_id' => Auth::id(),
                'applied_at' => now(),
                'expired_at' => $program->is_online ? now()->addDays($program->ticket->term) : $program->place->ended_at,
                'pay_status' => ProgramStudent::$PAY_PAID,
                'is_repeated' => $program->canRepeat(),
            ]);
        } else {
            return ProgramStudent::updateOrCreate([
                'ticket_id' => $program->ticket->id,
                'user_id' => Auth::id(),
            ], [
                'ticket_id' => $program->ticket->id,
                'user_id' => Auth::id(),
                'applied_at' => now(),
                'is_repeated' => $program->canRepeat(),
            ]);
        }
    }

    /**
     *  환불 가능 상태인지 체크.
     *
     * @return bool
     */
    public function cancelAvailable()
    {
        if ($this->attributes['pay_status'] != self::$PAY_PAID) {
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

        if ($this->ticket->program->is_online) {
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

    public function ticket()
    {
        return $this->belongsTo(ProgramTicket::class, 'ticket_id', 'id');
    }

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
}
