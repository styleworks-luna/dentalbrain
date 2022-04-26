<?php

namespace App\Models\Membership;

use App\DTO\Payment\TossPaymentsResponse;
use App\Models\Payments\TossPayment;
use App\Models\User;
use App\Traits\HasPayStatus;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * @property Carbon|null started_at
 * @property mixed|null expired_at
 * @property int|null applied_days
 * @property int pay_status
 */
class Membership extends Model
{
    use HasPayStatus, SoftDeletes;

    static $PriceMap = [
        30 => 29000,
        365 => 99000,
    ];
    protected $table = 'memberships';
    protected $guarded = [];
    protected $dates = [
        'started_at', 'expired_at', 'last_applied_at',
    ];

    /**
     * @param TossPaymentsResponse $response
     * @param TossPayment $payment
     * @param $days
     * @return Builder|Model
     */
    static function createWhenTossSuccess(TossPaymentsResponse $response, TossPayment $payment, $days)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($response->isCard() || $response->isTransfer()) {
            $pay_status = Membership::$PAY_PAID;
            $started_at = $user->getStartedAtWhenPaid();
            $expired_at = $user->getExpiredAtWhenPaid($days);
        } elseif ($response->isVirtualAccount()) {
            $pay_status = Membership::$PAY_IN_PROCESS;
            $started_at = null;
            $expired_at = null;
        } else {
            $pay_status = Membership::$PAY_PAID;
            $started_at = $user->getStartedAtWhenPaid();
            $expired_at = $user->getExpiredAtWhenPaid($days);
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

    /**
     * @param TossPayment|Model $payment
     * @param $days
     * @return Builder|Model
     */
    static function createWhenAnotherPay(TossPayment $payment, $days)
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

    /**
     * @param Authenticatable|User $user
     * @param $started_at
     * @param $expired_at
     * @return Builder|Model
     */
    static function createByAdmin($user, $started_at, $expired_at)
    {
        return Membership::query()->create([
            'user_id' => $user->id,
            'pay_status' => Membership::$PAY_PAID,
            'started_at' => $started_at,
            'expired_at' => $expired_at,
            'last_applied_at' => now(),
        ]);
    }

    public function updateWhenMembershipCancel(): bool
    {
        return $this->update([
            'pay_status' => Membership::$PAY_REFUNDED
        ]);
    }

    /**
     *  사용 중 + 사용 전
     *
     * @param $query
     * @return mixed
     */
    public function scopeAvailable($query)
    {
        return $query->where('expired_at', '>', now())
            ->whereIn('pay_status', Membership::$USER_PAID_STATUS)
            ->orderByDesc('expired_at');
    }

    /**
     *  사용 중인 유료 회원
     *
     * @param Builder $query
     * @return mixed
     */
    public function scopeInUse($query)
    {
        return $query->where('expired_at', '>', now())
            ->where('started_at', '<', now())
            ->whereIn('pay_status', Membership::$USER_PAID_STATUS)
            ->orderByDesc('expired_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(TossPayment::class, 'payment_id', 'id');
    }

    public function updateWhenConfirmAnotherPay($user)
    {
        return $this->update([
            'pay_status' => Membership::$PAY_ANOTHER_PAID,
            'started_at' => $user->getStartedAtWhenPaid(),
            'expired_at' => $user->getExpiredAtWhenPaid($this->applied_days),
        ]);
    }
}
