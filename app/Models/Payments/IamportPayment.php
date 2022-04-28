<?php

namespace App\Models\Payments;

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Payment;

class IamportPayment extends PaymentGatewayModel
{
    protected $table ='payments_iamport';

    protected $guarded = [];

    function getPgType(): string
    {
        return "iamport";
    }
}
