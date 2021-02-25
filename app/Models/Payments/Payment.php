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
    protected $guarded = [];

    /**
     * @param TossPaymentsResponse $response
     * @return Builder|Model|Payment
     */
    static function createByTossSuccess(TossPaymentsResponse $response)
    {
        if ($response->isCard()) {
            return Payment::query()->create([
                'paymentKey' => $response['paymentKey'],
                'orderId' => $response['orderId'],
                'totalAmount' => $response['totalAmount'],
                'receiptUrl' => $response['card'] ? $response['card']['receiptUrl'] : null,
                'method' => $response['method'],
                'status' => $response['status'],
                'useDiscount' => $response['useDiscount'],
                'discountAmount' => $response['discountAmount'],
                'secret' => $response['secret'],
                'full_response' => $response->getFullResponse(),
                'requestedAt' => Carbon::parse($response['requestedAt'])->toDateTime(),
                'approvedAt' => Carbon::parse($response['approvedAt'])->toDateTime(),
            ]);
        } elseif ($response->isVirtualAccount()) {
            return Payment::query()->create([
                'paymentKey' => $response['paymentKey'],
                'orderId' => $response['orderId'],
                'totalAmount' => $response['totalAmount'],
                'method' => $response['method'],
                'status' => $response['status'],

                'va_accountNumber' => $response['virtualAccount']['accountNumber'],
                'va_bank' => $response['virtualAccount']['bank'],
                'va_customerName' => $response['virtualAccount']['customerName'],
                'va_dueDate' => $response['virtualAccount']['dueDate'],
                'va_refundStatus' => $response['virtualAccount']['refundStatus'],

                'useDiscount' => $response['useDiscount'],
                'discountAmount' => $response['discountAmount'],
                'secret' => $response['secret'],
                'full_response' => $response->getFullResponse(),
                'requestedAt' => Carbon::parse($response['requestedAt'])->toDateTime(),
                'approvedAt' => Carbon::parse($response['approvedAt'])->toDateTime(),
            ]);
        }
    }

    public function student()
    {
        return $this->hasOne(ProgramStudent::class, 'payment_id', 'id');
    }

    public function updateByToss(TossPaymentsResponse $response)
    {
        if ($response->isCard()) {
            return $this->update([
                    'paymentKey' => $response['paymentKey'],
                    'orderId' => $response['orderId'],
                    'totalAmount' => $response['totalAmount'],
                    'receiptUrl' => $response['card'] ? $response['card']['receiptUrl'] : null,
                    'method' => $response['method'],
                    'status' => $response['status'],
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
                'paymentKey' => $response['paymentKey'],
                'orderId' => $response['orderId'],
                'totalAmount' => $response['totalAmount'],
                'method' => $response['method'],
                'status' => $response['status'],

                'va_accountNumber' => $response['virtualAccount']['accountNumber'],
                'va_bank' => $response['virtualAccount']['bank'],
                'va_customerName' => $response['virtualAccount']['customerName'],
                'va_dueDate' => $response['virtualAccount']['dueDate'],
                'va_refundStatus' => $response['virtualAccount']['refundStatus'],

                'useDiscount' => $response['useDiscount'],
                'discountAmount' => $response['discountAmount'],
                'secret' => $response['secret'],
                'full_response' => $response->getFullResponse(),
                'requestedAt' => Carbon::parse($response['requestedAt'])->toDateTime(),
                'approvedAt' => Carbon::parse($response['approvedAt'])->toDateTime(),
            ]);
        }
    }
}
