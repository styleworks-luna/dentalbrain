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

    if(!function_exists('changePaymentMethodName')){
        /**
         * @param $paymentMethodName
         * @return string
         */
        function changePaymentMethodName($paymentMethodName){
            switch($paymentMethodName){
                case '카드':
                    return '신용카드';
                case '무통장입금':
                    return '무통장입금(가상계좌)';
                default:
                    return '없음';
                    break;
            }
        }
    }
}
