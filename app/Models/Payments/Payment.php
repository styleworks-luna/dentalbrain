<?php

namespace App\Models\Payments;

use App\Models\Program\ProgramStudent;
use App\Payments\TossPayments\TossPaymentsResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Payment extends Model
{
    use SoftDeletes;

    protected $table = 'payments';
    protected $casts = [
        'requestedAt' => 'datetime',
        'va_dueDate' => 'datetime'
    ];
    protected $guarded = [];

    /**
     * 토스 DTO를 통해 생성
     *
     * @param TossPaymentsResponse $response
     * @return Builder|Model|Payment
     */
    static function createByTossSuccess(TossPaymentsResponse $response)
    {
        return Payment::query()->create(self::getPaymentData($response));
    }

    /**
     *  저장해야할 내용 합침 ( 기본 내용 + 결제 수단별 내용 )
     *
     * @param TossPaymentsResponse $response
     * @return array
     */
    private static function getPaymentData(TossPaymentsResponse $response): array
    {
        logger('???', [$response->getArray()]);
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
                'trans_accountNumber' => $response['transfer']['accountNumber'],
                'trans_bank' => $response['transfer']['bank'],
                'trans_settlementStatus' => $response['transfer']['settlementStatus'],
            ];
        }
    }

    /**
     * 토스 DTO를 통해 업데이트
     *
     * @param TossPaymentsResponse $response
     * @return bool
     */
    public function updateByToss(TossPaymentsResponse $response)
    {
        return $this->update(self::getPaymentData($response));
    }

    public function student()
    {
        return $this->hasOne(ProgramStudent::class, 'payment_id', 'id');
    }

    public function isCard()
    {
        return $this->attributes['method'] == '카드';
    }

    public function isVirtualAccount()
    {
        return $this->attributes['method'] == '가상계좌';
    }

    public function isTransfer()
    {
        return $this->attributes['method'] == '계좌이체';
    }
}
