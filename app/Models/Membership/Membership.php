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

class Membership extends Model
{
    use HasPayStatus, SoftDeletes;

    static $PriceMap = [
        30 => 30000,
        100 => 100000,
    ];
    protected $table = 'memberships';
    protected $guarded = [];

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

    private static function getStartedAtWhenPaid()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->availableLatestMembership()) {
            return $user->availableLatestMembership()->expired_at;
        } else {
            return now();
        }
    }

    private static function getExpiredAtWhenPaid($days): Carbon
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->availableLatestMembership()) {
            return Carbon::parse($user->availableLatestMembership()->expired_at)->addDays($days);
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

    static function createWhenUserEdit($startedAt, $expiredAt, $user) {

        $membership = Membership::query()->create([
            'user_id' => Auth::id(),
            'pay_status' => Membership::$PAY_PAID,
            'last_applied_at' => now(),
            'started_at' => $startedAt,
            'expired_at' => $expiredAt,
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

    /**
     *  사용 중인 유료 회원
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('expired_at', '>', now())->where('started_at', '<', now());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function updateWhenConfirmAnotherPay()
    {
        return $this->update([
            'pay_status' => Membership::$PAY_ANOTHER_PAID,
            'started_at' => self::getStartedAtWhenPaid(),
            'expired_at' => self::getExpiredAtWhenPaid($this->days),
        ]);
    }
}
