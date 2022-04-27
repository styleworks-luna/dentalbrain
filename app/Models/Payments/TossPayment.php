<?php

namespace App\Models\Payments;

use App\DTO\Payment\TossPaymentsResponse;
use App\Services\Payment\TossPaymentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class TossPayment extends PaymentGatewayModel
{
    use SoftDeletes;

    static $ANOTHER_DONE = 'ANOTHER_DONE';
    static $ANOTHER_REJECTED = 'ANOTHER_REJECTED';
    static $ANOTHER_PROGRESS = 'ANOTHER_PROGRESS';
    static $CANCELED = 'CANCELED';
    static $DONE = 'DONE';

    protected $table = 'payments_toss';
    protected $casts = [
        'requestedAt' => 'datetime',
        'va_dueDate' => 'datetime'
    ];
    protected $guarded = [];

    /**
     * 토스 DTO를 통해 업데이트
     *
     * @param TossPaymentsResponse $response
     * @return bool
     * @throws \Exception
     */
    public function updateByToss(TossPaymentsResponse $response): bool
    {
        return $this->update(TossPaymentFactory::getPaymentData($response));
    }

    /**
     *  별도 결제 확인시에 Payment 업데이트
     *
     * @return bool
     */
    public function updateWhenConfirmAnotherPay()
    {
        return $this->update([
            'approvedAt' => now(),
            'status' => self::$ANOTHER_DONE,
        ]);
    }

    public function cancelAnotherPay()
    {
        return $this->update([
            'status' => self::$ANOTHER_REJECTED,
            'full_response' => json_encode(
                array_merge(
                    json_decode($this->attributes['full_response'], true) ?: [],
                    [
                        'cancels' => [
                            [
                                'cancelAmount' => $this->attributes['totalAmount'],
                                'canceledAt' => now()->toIso8601String(),
                            ],
                        ]
                    ]
                ), JSON_UNESCAPED_UNICODE),
        ]);
    }

    public function revert()
    {
        return $this->update([
            'approvedAt' => null,
            'status' => self::$ANOTHER_PROGRESS
        ]);
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

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopePaid($query)
    {
        return $query->whereIn('status', [self::$ANOTHER_DONE, self::$DONE]);
    }

    function getPgType(): string
    {
        return "toss";
    }
}
