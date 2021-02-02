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
