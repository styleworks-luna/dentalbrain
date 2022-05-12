<?php

namespace App\Traits;

trait HasCertificateStatus
{
    /**
     * 결제 대기
     * @var int
     */
    static $DO_NOT_PAID = 1;

    /**
     *  합격/불합격 대기중
     * @var int
     */
    static $WAITING = 2;

    /**
     * 불합격
     * @var int
     */
    static $FAILED = 3;

    /**
     * 합격
     * @var int
     */
    static $PASS = 4;
}
