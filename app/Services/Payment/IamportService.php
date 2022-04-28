<?php

namespace App\Services\Payment;

use App\Http\Requests\Payments\SuccessPayments;
use App\Models\Payments\IamportPayment;
use Iamport\RestClient\Iamport;
use Iamport\RestClient\Request\Payment;
use Illuminate\Support\Facades\Log;

class IamportService
{
    private $iamport;

    /**
     * @param Iamport $iamport
     */
    public function __construct(Iamport $iamport)
    {
        $this->iamport = $iamport;
    }


    /**
     * @throws \Exception
     */
    public function createBySuccess(SuccessPayments $request)
    {
        $imp_uid = $request->getImpUid();
        $merchant_uid = $request->getMerchantUid();

        $result = $this->iamport->callApi(Payment::withImpUid($imp_uid));
        if ($result->isSuccess()) {
            Log::error("CALL API ERROR IN IAMPORT_CREATE_BY_SUCCESS", [$result->getError(), $result->getData()]);
            throw new \Exception("API 통신에 실패하였습니다.", [$result->getData(), $result->getData()]);
        }
        return IamportPayment::query()->create($result->getData());
    }
}
