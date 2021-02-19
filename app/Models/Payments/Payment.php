<?php

namespace App\Models\Payments;

use App\Payments\TossPayments\TossPaymentsResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Payment extends Model
{
    protected $table = 'payments';
    protected $guarded = [];

    static function createByToss(TossPaymentsResponse $response)
    {
        return Payment::query()->create([
            'paymentKey' => $response['paymentKey'],
            'orderId' => $response['orderId'],
            'totalAmount' => $response['totalAmount'],
            'receiptUrl' => $response['card'] ? $response['card']['receiptUrl'] : null,
            'method' => $response['method'],
            'status' => $response['status'],
            'refundStatus' => $response['virtualAccount'] ? $response['virtualAccount']['refundStatus'] : null,
            'useDiscount' => $response['useDiscount'],
            'discountAmount' => $response['discountAmount'],
            'secret' => $response['secret'],
            'full_response' => $response->getFullResponse(),
            'requestedAt' => Carbon::parse($response['requestedAt'])->toDateTime(),
            'approvedAt' => Carbon::parse($response['approvedAt'])->toDateTime(),
        ]);
    }

    public function updateByToss(TossPaymentsResponse $response)
    {
        return $this->update([
                'paymentKey' => $response['paymentKey'],
                'orderId' => $response['orderId'],
                'totalAmount' => $response['totalAmount'],
                'receiptUrl' => $response['card'] ? $response['card']['receiptUrl'] : null,
                'method' => $response['method'],
                'status' => $response['status'],
                'refundStatus' => $response['virtualAccount'] ? $response['virtualAccount']['refundStatus'] : null,
                'useDiscount' => $response['useDiscount'],
                'discountAmount' => $response['discountAmount'],
                'secret' => $response['secret'],
                'full_response' => $response->getFullResponse(),
                'requestedAt' => Carbon::parse($response['requestedAt'])->toDateTime(),
                'approvedAt' => Carbon::parse($response['approvedAt'])->toDateTime(),
            ]
        );
    }
}
