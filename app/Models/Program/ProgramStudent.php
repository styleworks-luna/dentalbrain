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
        'is_repeated' => 'boolean'
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
                'expired_at' => now()->addDays($program->ticket->term),
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
