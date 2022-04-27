<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

class AnotherPayment extends PaymentGatewayModel
{
    function getPgType(): string
    {
        return "another";
    }
}
