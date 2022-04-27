<?php

namespace App\Models\Payments;

use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Payment;

class IamportPayment extends PaymentGatewayModel
{
    function getPgType(): string
    {
        return "iamport";
    }

    public function test(Iamport $iamport)
    {
        $result = $iamport->callApi(Payment::withMerchantUid("merchant_uid"));
    }
}
