<?php

if (!function_exists('carbonDate')) {
    /**
     * Carbon 포맷으로 변환.
     * @param $object
     * @param $format
     * @see https://carbon.nesbot.com/docs/#api-localization
     * @return string
     */
    function carbonDate($object, $format)
    {
        return \Carbon\Carbon::parse($object)->locale('ko_KR')->isoFormat($format);
    }
}

if(!function_exists('changePaymentMethodName')){

    function changePaymentMethodName($paymentMethodName){
        switch($paymentMethodName){
            case '카드':
                return '신용카드';
            case '가상계좌':
                return '무통장입금(가상계좌)';
            case '계좌이체' :
                return '실시간 계좌이체';
            default:
                return $paymentMethodName;
                break;
        }
    }
}

if(!function_exists('changePaymentStatusName')){
    function changePaymentStatusName($status){
        switch($status){
            case 'READY':
                return '준비됨';
            case 'IN_PROGRESS':
                return '진행중';
            case 'WAITING_FOR_DEPOSIT':
                return '입금 대기중';
            case 'DONE':
                return '결제 완료';
            case 'CANCELED':
                return '결제 취소';
            case 'ABORTED':
                return '결제 중단';
            case 'PARTIAL_CANCELED ':
                return '부분 취소';
            default:
                return $status;
                break;
        }
    }
}
