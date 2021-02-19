<?php


namespace App\Payments\TossPayments;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class TossPayments
{
    private $paymentKey;
    private $response = null;

    public function __construct(string $paymentKey)
    {
        $this->paymentKey = $paymentKey;
    }

    public function success($orderId, $amount)
    {
        try {
            $client = new Client();
            $response = $client->post($this->getAcceptUrl(), [
                'auth' => [
                    env('TOSS_PAYMENTS_SECRET'),
                    '',
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => [
                    "orderId" => $orderId,
                    "amount" => $amount,
                ],
            ]);
        } catch (GuzzleException $e) {
            Log::error('TOSS API CALL ERROR', [
                $e,
                'paymentKey' => $this->paymentKey,
                'orderId' => $orderId,
                'amount' => $amount]);
            return false;
        }

        if ($response->getStatusCode() !== 200) {
            Log::error('TOSS API SUCCESS CALL ERROR', [
                'code' => $response->getStatusCode(),
                'body' => $response->getBody(),
                'paymentKey' => $this->paymentKey,
                'orderId' => $orderId,
                'amount' => $amount
            ]);
            return false;
        }

        $this->response = $response->getBody()->getContents();

        return json_decode($this->response, true) ?: false;
    }

    /**
     * 결제 승인 주소
     *
     * @return string
     */
    private function getAcceptUrl()
    {
        return 'https://api.tosspayments.com/v1/payments/' . $this->paymentKey;
    }

    /**
     * 했던 API 콜 결과 전부 받아옴.
     *
     * @return null|string 결과 받은 적이 없으면 null.
     */
    public function getFullResponse()
    {
        return $this->response;
    }

    /**
     *
     *
     * @param string $reason
     * @param int|string|null $cancelAmount
     * @param int|string|null $taxAmount
     * @return false|TossPaymentsResponse 실패시 false, 성공시 결과 DTO 반환.
     * @see https://docs.tosspayments.com/api#%EA%B2%B0%EC%A0%9C-%EC%B7%A8%EC%86%8C
     */
    public function cancelCard(string $reason, $cancelAmount = null, $taxAmount = null)
    {
        return $this->cancel($reason, null, null, null, $cancelAmount, $taxAmount);
    }

    /**
     * @param string $reason
     * @param string|null $bank
     * @param string|null $accountNumber
     * @param string|null $holderName
     * @param int|string|null $cancelAmount
     * @param int|string|null $taxAmount
     * @return TossPaymentsResponse|false
     */
    protected function cancel(string $reason, $bank = null, $accountNumber = null, $holderName = null, $cancelAmount = null, $taxAmount = null)
    {
        $this->getCancelUrl();
        $client = new Client();
        $jsonData = [
            'cancelReason' => $reason
        ];
        if ($cancelAmount !== null) {
            $jsonData['cancelAmount'] = $cancelAmount;
        }
        if ($taxAmount !== null) {
            $jsonData['taxAmount'] = $taxAmount;
        }
        try {
            $response = $client->post($this->getCancelUrl(), [
                'auth' => [
                    env('TOSS_PAYMENTS_SECRET'),
                    '',
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => $jsonData,
            ]);
        } catch (GuzzleException $e) {
            Log::error('TOSS API CANCEL CALL ERROR', [
                $e,
                'paymentKey' => $this->paymentKey,
                'reason' => $reason]);
            return false;
        }

        if ($response->getStatusCode() !== 200) {
            Log::error('TOSS API SUCCESS CALL ERROR', [
                'code' => $response->getStatusCode(),
                'body' => $response->getBody(),
                'paymentKey' => $this->paymentKey,
                'reason' => $reason,
            ]);
            return false;
        }

        $this->response = new TossPaymentsResponse($response->getBody()->getContents());

        return $this->response ?: false;
    }

    /**
     * 결제 취소 주소
     * @return string
     */
    private function getCancelUrl()
    {
        return 'https://api.tosspayments.com/v1/payments/' . $this->paymentKey . '/cancel';
    }

    /**
     * @param string $reason
     * @param string $bank
     * @param string $accountNumber
     * @param string $holderName
     * @param null|int|string $cancelAmount
     * @param null|int|string $taxAmount
     * @return false|TossPaymentsResponse
     * @see https://docs.tosspayments.com/api#%EA%B2%B0%EC%A0%9C-%EC%B7%A8%EC%86%8C
     */
    public function cancelVirtualAccount(string $reason, string $bank, string $accountNumber,
                                         string $holderName, $cancelAmount = null, $taxAmount = null)
    {
        return $this->cancel($reason, $bank . $accountNumber, $holderName, $cancelAmount, $taxAmount);
    }
}
