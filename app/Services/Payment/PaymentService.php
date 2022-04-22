<?php


namespace App\Services\Payment;


use App\DTO\Payment\CancelPaymentDto;
use App\Models\Payments\Payment;
use App\Models\Program\ProgramStudent;
use App\Payments\TossPayments\TossPaymentsService;
use App\Traits\HasPayStatus;
use Illuminate\Support\Facades\Log;

abstract class PaymentService
{
    use HasPayStatus;

    /**
     * @param Payment $payment
     * @param int $pay_status From HasPayStatus trait
     * @param CancelPaymentDto $dto
     * @return bool
     */
    public static function cancelPaid(Payment $payment, $pay_status, CancelPaymentDto $dto): bool
    {
        if ($pay_status == ProgramStudent::$PAY_PAID || $pay_status == ProgramStudent::$PAY_IN_REFUND_PROCESS) {
            // PG 사 통한 결제
            $tossPayment = new TossPaymentsService($payment->paymentKey);
            switch ($payment->method) {
                case '계좌이체':
                    $response = $tossPayment->cancelTransfer($dto->getReason());
                    break;
                case '카드':
                    $response = $tossPayment->cancelCard($dto->getReason());
                    break;
                case '가상계좌':
                    $response = $tossPayment->cancelVirtualAccount(
                        $dto->getReason(), $dto->getBank(), $dto->getBank(), $dto->getHolderName()
                    );
                    break;
                //case '휴대폰':
                default:
                    $response = false;
                    Log::error('INVALID METHOD', $dto->getData());
                    break;
            }
            if ($response === false) {
                return false;
            }

            $payment->updateByToss($response);

        } elseif ($pay_status == ProgramStudent::$PAY_ANOTHER_IN_PROCESS
            || $pay_status == ProgramStudent::$PAY_ANOTHER_PAID) {
            $payment->cancelAnotherPay();
        }

        return true;
    }
}
