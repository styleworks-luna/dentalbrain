<?php

namespace App\Models\Payments;

use App\Models\Membership\Membership;
use App\Models\Program\ProgramStudent;
use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

abstract class PaymentGatewayModel extends Model
{
    abstract function getPgType(): string;

    public function membership()
    {
        return $this->hasOneThrough(Membership::class, PaymentModel::class, 'pg_id', 'payment_id');
    }

    public function student()
    {
        return $this->hasOneThrough(ProgramStudent::class, PaymentModel::class, 'pg_id', 'payment_id');
    }

    public function recruit()
    {
        return $this->hasOneThrough(Recruit::class, PaymentModel::class, 'pg_id', 'payment_id');
    }

    public function payment()
    {
        return $this->morphOne(PaymentModel::class, 'pg', $this->getPgType());
    }
}
