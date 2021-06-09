<?php

namespace App\Models\Payments;

use App\Models\Membership\Membership;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Payments\TossPayments\TossPaymentsResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Payment extends Model
{
    use SoftDeletes;

    static $ANOTHER_DONE = 'ANOTHER_DONE';
    static $ANOTHER_REJECTED = 'ANOTHER_REJECTED';
    static $ANOTHER_PROGRESS = 'ANOTHER_PROGRESS';

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
                'trans_bank' => $response['transfer']['bank'],
                'trans_settlementStatus' => $response['transfer']['settlementStatus'],
            ];
        }
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
        return self::CreateAnotherPayment($student->getPrice());
    }

    protected static function CreateAnotherPayment($price)
    {
        $paymentKey = 'another_' . Str::random('5');
        $orderId = 'another_' . Str::random('5');

        return Payment::query()->create([
            'paymentKey' => $paymentKey,
            'orderId' => $orderId,
            'totalAmount' => $price,
            'method' => '계좌입금',
            'status' => self::$ANOTHER_PROGRESS,
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
     * @param Program $program
     * @param ProgramStudent $student
     * @return Builder|Model
     */
    public static function createWhenMembershipAnotherPay($days)
    {
        return self::CreateAnotherPayment(Membership::$PriceMap[$days]);
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

    public function membership()
    {
        return $this->hasOne(Membership::class, 'payment_id', 'id');
    }
}
