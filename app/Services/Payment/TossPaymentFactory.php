<?php

namespace App\Services\Payment;

use App\DTO\Payment\TossPaymentsResponse;
use App\Models\Membership\Membership;
use App\Models\Payments\TossPayment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TossPaymentFactory
{
    private function __construct()
    {
    }

    /**
     * 토스 DTO를 통해 생성
     *
     * @param TossPaymentsResponse $response
     * @return Builder|Model|TossPayment
     * @throws \Exception
     */
    static function createByTossSuccess(TossPaymentsResponse $response)
    {
        return TossPayment::query()->create(self::getPaymentData($response));
    }

    /**
     *  저장해야할 내용 합침 ( 기본 내용 + 결제 수단별 내용 )
     *
     * @param TossPaymentsResponse $response
     * @return array
     * @throws \Exception
     */
    private static function getPaymentData(TossPaymentsResponse $response): array
    {
        return array_merge(self::getPaymentBasicData($response), self::getPaymentsAdditionalData($response));
    }

    /**
     *  토스 Response 에 담겨있는 기본적인 DB 저장 내용
     *
     * @param TossPaymentsResponse $response
     * @return array
     */
    private static function getPaymentBasicData(TossPaymentsResponse $response): array
    {
        return [
            // 결제정보
            'paymentKey' => $response['paymentKey'],
            'orderId' => $response['orderId'],
            'totalAmount' => $response['totalAmount'],
            'method' => $response['method'],
            'status' => $response['status'],

            // 할인정보
            'useDiscount' => $response['useDiscount'],
            'discountAmount' => $response['discountAmount'],

            // 기타 정보
            'secret' => $response['secret'],
            'full_response' => $response->getFullResponse(),
            'requestedAt' => Carbon::parse($response['requestedAt'])->toDateTime(),
            'approvedAt' => Carbon::parse($response['approvedAt'])->toDateTime(),
        ];
    }

    /**
     *  결제 수단에 따른 추가적인 정보 저장 내용
     *
     * @param TossPaymentsResponse $response
     * @return array|null[]
     * @throws \Exception
     */
    private static function getPaymentsAdditionalData(TossPaymentsResponse $response): array
    {
        if ($response->isCard()) {
            return [
                // 신용카드 영수증
                'receiptUrl' => $response['card'] ? $response['card']['receiptUrl'] : null
            ];
        } elseif ($response->isVirtualAccount()) {
            return [
                // 가상계좌 정보
                'va_accountNumber' => $response['virtualAccount']['accountNumber'],
                'va_bank' => $response['virtualAccount']['bank'],
                'va_customerName' => $response['virtualAccount']['customerName'],
                'va_dueDate' => Carbon::parse($response['virtualAccount']['dueDate'])->toDateTime(),
                'va_refundStatus' => $response['virtualAccount']['refundStatus'],
            ];
        } elseif ($response->isTransfer()) {
            return [
                // 가상계좌 정보
                'trans_bank' => $response['transfer']['bank'],
                'trans_settlementStatus' => $response['transfer']['settlementStatus'],
            ];
        }
        Log::error('unknown pay method');
        throw new \Exception('입력 정보가 잘못되었습니다.');
    }

    /**
     *  계좌입금 Payment 생성
     *
     * @param Program $program
     * @param ProgramStudent $student
     * @return Builder|Model
     */
    public static function createWhenAnotherPayProcess(Program $program, ProgramStudent $student)
    {
        return self::createAnotherPayment($student->getPrice());
    }

    protected static function createAnotherPayment($price)
    {
        $paymentKey = 'another_' . Str::random('5');
        $orderId = 'another_' . Str::random('5');

        return TossPayment::query()->create([
            'paymentKey' => $paymentKey,
            'orderId' => $orderId,
            'totalAmount' => $price,
            'method' => '계좌입금',
            'status' => TossPayment::$ANOTHER_PROGRESS,
            'useDiscount' => 0,
            'full_response' => json_encode([
                'mId' => 'si_dentalbrain',
                'paymentKey' => $paymentKey,
                'orderId' => $orderId,
                'method' => '계좌입금',
                'totalAmount' => $price,
                'cancels' => null,
            ], JSON_UNESCAPED_UNICODE),
            'requestedAt' => now(),
        ]);
    }

    /**
     *  계좌입금 Payment 생성
     *
     * @param $days
     * @return Builder|Model
     */
    public static function createWhenMembershipAnotherPay($days)
    {
        return self::createAnotherPayment(Membership::$PriceMap[$days]);
    }
}
