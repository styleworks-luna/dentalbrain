<?php

namespace App\Models\Membership;

use App\Models\Payments\Payment;
use App\Models\User;
use App\Payments\TossPayments\TossPaymentsResponse;
use App\Traits\HasPayStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed|null started_at
 * @property mixed|null expired_at
 * @property int|null applied_days
 * @property int pay_status
 */
class Membership extends Model
{
    use HasPayStatus, SoftDeletes;

    static $PriceMap = [
        30 => 30000,
        100 => 100000,
    ];
    protected $table = 'memberships';
    protected $guarded = [];
    protected $dates = [
        'started_at', 'expired_at'
    ];

    /**
     * @param TossPaymentsResponse $response
     * @param Payment $payment
     * @param $days
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    static function createWhenTossSuccess(TossPaymentsResponse $response, Payment $payment, $days)
    {
        if ($response->isCard() || $response->isTransfer()) {
            $pay_status = Membership::$PAY_PAID;
            $started_at = self::getStartedAtWhenPaid();
            $expired_at = self::getExpiredAtWhenPaid($days);
        } elseif ($response->isVirtualAccount()) {
            $pay_status = Membership::$PAY_IN_PROCESS;
            $started_at = null;
            $expired_at = null;
        } else {
            $pay_status = Membership::$PAY_PAID;
            $started_at = self::getStartedAtWhenPaid();
            $expired_at = self::getExpiredAtWhenPaid($days);
        }

        $membership = Membership::query()->create([
            'user_id' => Auth::id(),
            'payment_id' => $payment->id,
            'pay_status' => $pay_status,
            'last_applied_at' => now(),
            'applied_days' => $days,
            'started_at' => $started_at,
            'expired_at' => $expired_at,
        ]);

        return $membership;
    }

    public function updateWhenMembershipCancel(): bool
    {
        return $this->update([
            'pay_status' => Membership::$PAY_REFUNDED
        ]);
    }

    private static function getStartedAtWhenPaid($user = null)
    {
        if ($user == null) {
            /** @var User $user */
            $user = Auth::user();
        }

        if ($user->isPaid()) {
            return $user->membership_expired_at;
        } else {
            return now();
        }
    }

    private static function getExpiredAtWhenPaid($days, $user = null): Carbon
    {
        if ($user == null) {
            /** @var User $user */
            $user = Auth::user();
        }

        if ($user->isPaid()) {
            return Carbon::parse($user->membership_expired_at)->addDays($days);
        } else {
            return now()->addDays($days);
        }
    }

    static function createWhenAnotherPay(Payment $payment, $days)
    {
        $membership = Membership::query()->create([
            'user_id' => Auth::id(),
            'payment_id' => $payment->id,
            'pay_status' => Membership::$PAY_ANOTHER_IN_PROCESS,
            'last_applied_at' => now(),
            'applied_days' => $days,
            'started_at' => null,
            'expired_at' => null,
        ]);

        return $membership;
    }

    public function isAvailable(): bool
    {
        if (!isset($this->attributes['expired_at']) && !isset($this->attributes['started_at'])) {
            return false;
        }

        return $this->started_at < now() && now() < $this->expired_at;
    }

    /**
     *  사용 중 + 사용 전인 유료 회원
     *
     * @param $query
     * @return mixed
     */
    public function scopeAvailable($query)
    {
        return $query->where('expired_at', '>', now());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function updateWhenConfirmAnotherPay($user)
    {
        return $this->update([
            'pay_status' => Membership::$PAY_ANOTHER_PAID,
            'started_at' => self::getStartedAtWhenPaid($user),
            'expired_at' => self::getExpiredAtWhenPaid($this->applied_days, $user),
        ]);
    }
}
