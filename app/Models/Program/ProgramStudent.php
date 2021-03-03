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

    static $PAY_BEFORE = 0;
    static $PAY_IN_PROCESS = 1;
    static $PAY_PAID = 2;
    static $PAY_REFUNDED = 3;

    protected $appends = ['left_days'];
    protected $guarded = [];
    protected $casts = [
        'is_repeated' => 'boolean',
        'applied_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    /**
     * @param TossPaymentsResponse $response
     * @param Program $program
     * @param Payment $payment
     * @return ProgramStudent|Model
     */
    static function updateWhenTossSuccess(TossPaymentsResponse $response, Program $program, Payment $payment)
    {
        $programStudent = ProgramStudent::query()->where('user_id', '=', Auth::id())
            ->where('ticket_id', '=', $program->ticket->id)->first();
        if ($response->isCard()) {
            $programStudent->update([
                'payment_id' => $payment->id,
                'expired_at' => now()->addDays($program->ticket->term),
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
     * @param Program $program
     * @param string $email
     * @param string $phone
     * @return ProgramStudent
     */
    static function updateOrCreateWhenApplySuccess(Program $program, string $email, string $phone)
    {
        if ($program->ticket->is_free) {
            return ProgramStudent::updateOrCreate([
                'ticket_id' => $program->ticket->id,
                'user_id' => Auth::id(),
            ], [
                'ticket_id' => $program->ticket->id,
                'user_id' => Auth::id(),
                'email' => $email,
                'phone' => $phone,
                'applied_at' => now(),
                'expired_at' => $program->is_online ? now()->addDays($program->ticket->term) : $program->place->ended_at,
                'pay_status' => ProgramStudent::$PAY_PAID,
            ]);
        } else {
            return ProgramStudent::updateOrCreate([
                'ticket_id' => $program->ticket->id,
                'user_id' => Auth::id(),
            ], [
                'ticket_id' => $program->ticket->id,
                'user_id' => Auth::id(),
                'email' => $email,
                'phone' => $phone,
                'applied_at' => now(),
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
                strtotime($this->attributes['expired_at'] > now()->subDays(2)->unix())
                && strtotime($this->attributes['expired_at'] < now()->subDays(1)->unix())
            ) {
                return true;
            } else {
                return false;
            }
        }
    }

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
        return Carbon::now()->diff($this->attributes['expired_at'])->format('%r%a');
    }
}
