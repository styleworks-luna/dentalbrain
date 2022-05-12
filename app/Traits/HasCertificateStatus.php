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

    public static function translateStatus(int $status): string
    {
        switch ($status) {
            case HasCertificateStatus::$DO_NOT_PAID:
                return '결제 대기';
            case HasCertificateStatus::$WAITING:
                return '대기 중';
            case HasCertificateStatus::$FAILED:
                return '불합격';
            case HasCertificateStatus::$PASS:
                return '합격';
            default:
                return '오류';
        }
    }
}
