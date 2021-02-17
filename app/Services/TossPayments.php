<?php


namespace App\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class TossPayments
{
    private $paymentKey;
    private $response;

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
            Log::error('TOSS API CALL ERROR', [
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

    public function getFullResponse()
    {
        return $this->response;
    }
}
