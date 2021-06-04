<?php


namespace App\Payments\TossPayments;


use App\Exceptions\TossPaymentsException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
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

    /**
     * @throws TossPaymentsException
     */
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
        } catch (ClientException $e) {
            // 404, 400, 500 같은 에러
            $exception = new TossPaymentsException($e->getResponse(), $e);
            report($exception);
            throw $exception;
        } catch (GuzzleException $e) {
            // general error
            Log::error('TOSS API CALL ERROR', [
                $e,
                'paymentKey' => $this->paymentKey,
                'orderId' => $orderId,
                'amount' => $amount]);
            return false;
        }

        $this->response = new TossPaymentsResponse($response->getBody()->getContents());

        return $this->response ?: false;
    }

    /**
     * 결제 승인 주소
     *
     * @return string
     */
    protected function getAcceptUrl()
    {
        return 'https://api.tosspayments.com/v1/payments/' . $this->paymentKey;
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
        $client = new Client();
        $jsonData = [
            'cancelReason' => $reason
        ];

        if ($bank !== null) {
            $jsonData['refundReceiveAccount'] = [
                'bank' => $bank,
                'accountNumber' => $accountNumber,
                'holderName' => $holderName,
            ];
        }
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
                'json' => $jsonData,
            ]);
            return false;
        }

        if ($response->getStatusCode() !== 200) {
            Log::error('TOSS API SUCCESS CALL ERROR', [
                'code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
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
    protected function getCancelUrl()
    {
        return 'https://api.tosspayments.com/v1/payments/' . $this->paymentKey . '/cancel';
    }

    public function lookup()
    {
        $client = new Client();

        try {
            $response = $client->post($this->getLookupUrl(), [
                'auth' => [
                    env('TOSS_PAYMENTS_SECRET'),
                    '',
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);
        } catch (GuzzleException $e) {
            Log::error('TOSS API LOOKUP CALL ERROR', [
                $e,
                'paymentKey' => $this->paymentKey,
            ]);
            return false;
        }

        if ($response->getStatusCode() !== 200) {
            Log::error('TOSS API LOOKUP CALL ERROR', [
                'code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
                'paymentKey' => $this->paymentKey,
            ]);
            return false;
        }

        $this->response = new TossPaymentsResponse($response->getBody()->getContents());

        return $this->response ?: false;
    }

    protected function getLookupUrl()
    {
        return 'https://api.tosspayments.com/v1/payments/' . $this->paymentKey;
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
        return $this->cancel($reason, $bank, $accountNumber, $holderName, $cancelAmount, $taxAmount);
    }

    public function cancelTransfer(string $reason, $cancelAmount = null, $taxAmount = null)
    {
        return $this->cancel($reason, null, null, null, $cancelAmount, $taxAmount);
    }
}
