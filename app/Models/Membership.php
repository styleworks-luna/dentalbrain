<?php

namespace App\Models;

use App\Models\Payments\Payment;
use App\Traits\HasPayStatus;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasPayStatus;

    protected $table = 'memberships';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
}
