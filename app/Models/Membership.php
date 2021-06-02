<?php

namespace App\Models;

use App\Models\Payments\Payment;
use App\Payments\TossPayments\TossPaymentsResponse;
use App\Traits\HasPayStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Membership extends Model
{
    use HasPayStatus;

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
     * @return Membership|Model|HasOne
     */
    static function createOrUpdateByTossSuccess(TossPaymentsResponse $response, Payment $payment, $days)
    {
        /** @var User $user */
        $user = Auth::user();

        $membership = self::getMembershipWhenMembershipPay();
        $expired_at = self::getExpiredAtWhenMembershipPay($days);

        $membership->user_id = $user->id;
        $membership->payment_id = $payment->id;
        $membership->expired_at = $expired_at;
        $membership->last_applied_at = now();
        $membership->applied_days = $days;

        if ($response->isCard() || $response->isTransfer()) {
            $membership->pay_status = Membership::$PAY_PAID;
        } elseif ($response->isVirtualAccount()) {
            $membership->pay_status = Membership::$PAY_IN_PROCESS;
        }
        $membership->save();

        return $membership;
    }

    private static function getMembershipWhenMembershipPay()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->membership()->doesntExist()) {
            // 새로 유료회원 가입 한 경우.
            return new Membership;
        } else {
            // 기존 유료회원인 경우.
            return $user->membership;
        }
    }

    private static function getExpiredAtWhenMembershipPay($days)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->membership()->doesntExist()) {
            // 새로 유료회원 가입 한 경우.
            $expired_at = now()->addDays($days);
        } else {
            // 기존 유료회원인 경우.
            $membership = $user->membership;

            if (now() > $membership->expired_at) {
                // 중간에 유료회원 유지 기간이 끊겼던 경우 ( 재시작 )
                $expired_at = now()->addDays($days);
            } else {
                // 유료회원이 아직 있는 경우. ( 연장 )
                $expired_at = Carbon::parse($membership->expired_at)->addDays($days);
            }
        }

        return $expired_at;
    }

    static function createOrUpdateByAnotherPay(Payment $payment, $days)
    {
        /** @var User $user */
        $user = Auth::user();

        $membership = self::getMembershipWhenMembershipPay();

        $membership->user_id = $user->id;
        $membership->payment_id = $payment->id;
        $membership->last_applied_at = now();
        $membership->applied_days = $days;

        $membership->pay_status = Membership::$PAY_ANOTHER_IN_PROCESS;

        $membership->save();

        return $membership;
    }

    public function isAvailable(): bool
    {
        if (!isset($this->attributes['expired_at'])) {
            return false;
        }

        return $this->expired_at > now();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
}
