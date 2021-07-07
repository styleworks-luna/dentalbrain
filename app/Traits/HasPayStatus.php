<?php

namespace App\Traits;

trait HasPayStatus
{
    /**
     * 결제 아직 안했을 경우
     * @var int
     */
    static $PAY_BEFORE = 0;
    /**
     *  가상계좌 결제 진행중
     * @var int
     */
    static $PAY_IN_PROCESS = 1;
    /**
     * 결제 완료
     * @var int
     */
    static $PAY_PAID = 2;
    /**
     * 환불 완료
     * @var int
     */
    static $PAY_REFUNDED = 3;
    /**
     * 환불 요청됨
     * @var int
     */
    static $PAY_IN_REFUND_PROCESS = 4;

    /**
     * 별도 결제
     * @var int
     */
    static $PAY_ANOTHER_IN_PROCESS = 5;

    /**
     * 별도 결제
     * @var int
     */
    static $PAY_ANOTHER_PAID = 6;

    /**
     * $PAY_PAID, $PAY_IN_REFUND_PROCESS, $PAY_ANOTHER_IN_PROCESS, $PAY_ANOTHER_PAID
     * @var int[]
     */
    static $USER_CANCEL_AVAILABLE_STATUSES = [2, 4, 5, 6,];

    /**
     * $PAY_PAID, $PAY_ANOTHER_PAID
     * @var int[]
     */
    static $USER_PAID_STATUS = [2, 6,];
}
