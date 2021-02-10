<?php

namespace App\Models\Program;

use App\Models\Payments\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ProgramStudent extends Model
{
    use SoftDeletes;

    protected $appends = ['left_days'];
    protected $guarded = [];
    protected $casts = [
        'is_repeated' => 'boolean'
    ];

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
        return Carbon::now()->diff($this->attributes['expired_at'])->days;
    }
}
