<?php

namespace App\Models\Payments;

use App\Models\Program\ProgramStudent;
use App\Payments\TossPayments\TossPaymentsResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

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
        if ($response->isCard()) {
            return Payment::query()->create([
                // 결제정보
                'paymentKey' => $response['paymentKey'],
                'orderId' => $response['orderId'],
                'totalAmount' => $response['totalAmount'],
                'method' => $response['method'],
                'status' => $response['status'],

                // 신용카드 영수증
                'receiptUrl' => $response['card'] ? $response['card']['receiptUrl'] : null,

                // 할인정보
                'useDiscount' => $response['useDiscount'],
                'discountAmount' => $response['discountAmount'],

                'secret' => $response['secret'],
                'full_response' => $response->getFullResponse(),
                'requestedAt' => Carbon::parse($response['requestedAt'])->toDateTime(),
                'approvedAt' => Carbon::parse($response['approvedAt'])->toDateTime(),
            ]);
        } elseif ($response->isVirtualAccount()) {
            Log::debug('debug', [$response->getFullResponse()]);
            return Payment::query()->create([
                // 결제정보
                'paymentKey' => $response['paymentKey'],
                'orderId' => $response['orderId'],
                'totalAmount' => $response['totalAmount'],
                'method' => $response['method'],
                'status' => $response['status'],

                // 가상계좌 정보
                'va_accountNumber' => $response['virtualAccount']['accountNumber'],
                'va_bank' => $response['virtualAccount']['bank'],
                'va_customerName' => $response['virtualAccount']['customerName'],
                'va_dueDate' => Carbon::parse($response['virtualAccount']['dueDate'])->toDateTime(),
                'va_refundStatus' => $response['virtualAccount']['refundStatus'],

                // 할인정보
                'useDiscount' => $response['useDiscount'],
                'discountAmount' => $response['discountAmount'],

                'secret' => $response['secret'],
                'full_response' => $response->getFullResponse(),
                'requestedAt' => Carbon::parse($response['requestedAt'])->toDateTime(),
                'approvedAt' => $response['approvedAt'] != null ? Carbon::parse($response['approvedAt'])->toDateTime() : null,
            ]);
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
        if ($response->isCard()) {
            return $this->update([
                    // 결제정보
                    'paymentKey' => $response['paymentKey'],
                    'orderId' => $response['orderId'],
                    'totalAmount' => $response['totalAmount'],
                    'method' => $response['method'],
                    'status' => $response['status'],

                    // 신용카드 영수증
                    'receiptUrl' => $response['card'] ? $response['card']['receiptUrl'] : null,

                    // 할인정보
                    'useDiscount' => $response['useDiscount'],
                    'discountAmount' => $response['discountAmount'],

                    'secret' => $response['secret'],
                    'full_response' => $response->getFullResponse(),
                    'requestedAt' => Carbon::parse($response['requestedAt'])->toDateTime(),
                    'approvedAt' => Carbon::parse($response['approvedAt'])->toDateTime(),
                ]
            );
        } elseif ($response->isVirtualAccount()) {
            return $this->update([
                // 결제정보
                'paymentKey' => $response['paymentKey'],
                'orderId' => $response['orderId'],
                'totalAmount' => $response['totalAmount'],
                'method' => $response['method'],
                'status' => $response['status'],

                // 가상계좌 정보
                'va_accountNumber' => $response['virtualAccount']['accountNumber'],
                'va_bank' => $response['virtualAccount']['bank'],
                'va_customerName' => $response['virtualAccount']['customerName'],
                'va_dueDate' => Carbon::parse($response['virtualAccount']['dueDate'])->toDateTime(),
                'va_refundStatus' => $response['virtualAccount']['refundStatus'],

                // 할인정보
                'useDiscount' => $response['useDiscount'],
                'discountAmount' => $response['discountAmount'],

                'secret' => $response['secret'],
                'full_response' => $response->getFullResponse(),
                'requestedAt' => Carbon::parse($response['requestedAt'])->toDateTime(),
                'approvedAt' => $response['approvedAt'] != null ? Carbon::parse($response['approvedAt'])->toDateTime() : null,
            ]);
        }
    }

    public function student()
    {
        return $this->hasOne(ProgramStudent::class, 'payment_id', 'id');
    }

    public function cancels()
    {
        return $this->hasMany(Cancel::class, 'payment_id', 'id');
    }

    public function isCard()
    {
        return $this->attributes['method'] == '카드';
    }

    public function isVirtualAccount()
    {
        return $this->attributes['method'] == '가상계좌';
    }
}
