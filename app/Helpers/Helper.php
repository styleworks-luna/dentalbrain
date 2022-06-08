<?php

if (!function_exists('carbonDate')) {
    /**
     * Carbon 포맷으로 변환.
     * @param $object
     * @param $format
     * @return string
     * @see https://carbon.nesbot.com/docs/#api-localization
     */
    function carbonDate($object, $format)
    {
        return \Carbon\Carbon::parse($object)->locale('ko_KR')->isoFormat($format);
    }
}

if (!function_exists('changePaymentMethodName')) {

    function changePaymentMethodName($paymentMethodName)
    {
        switch ($paymentMethodName) {
            case '카드':
                return '신용카드';
            case '가상계좌':
                return '무통장입금(가상계좌)';
            case '계좌이체' :
                return '실시간 계좌이체';
            case '계좌입금' :
                return '계좌입금';
            default:
                return $paymentMethodName;
                break;
        }
    }
}

if (!function_exists('changePaymentStatusName')) {
    function changePaymentStatusName($status)
    {
        switch ($status) {
            case 'READY':
                return '준비됨';
            case 'IN_PROGRESS':
                return '진행중';
            case 'WAITING_FOR_DEPOSIT':
            case 'ANOTHER_PROGRESS' :
                return '입금 대기중';
            case 'DONE':
            case 'ANOTHER_DONE':
                return '결제 완료';
            case 'CANCELED':
                return '결제 취소';
            case 'ABORTED':
                return '결제 중단';
            case 'PARTIAL_CANCELED ':
                return '부분 취소';
            case 'ANOTHER_REJECTED':
                return '신청 취소됨';
            default:
                return $status;
                break;
        }
    }
}
if (!function_exists('sanitizeForFileName')) {
    function sanitizeForFileName(string $string)
    {
        //  / \ : * ? " < > |
        $str = preg_replace("/[\/\\\:\*\?\"\<\>\|]/", '', $string);
        if ($str == null) {
            return "오류";
        }
        return $str;
    }
}
