<?php

if (!function_exists('viewPrefix')) {
    /**
     *  에이전트 String 변환 후 "." 붙임.
     * ! 컨트롤러 내부에서 사용해야 함.
     * @return string mobile. || desktop.
     */
    function viewPrefix(): string
    {
        return session()->get('agent', "desktop") . ".";
    }
}
