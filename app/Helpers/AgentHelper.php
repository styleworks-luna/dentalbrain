<?php

if (!function_exists('viewPrefix')) {
    /**
     * ! 컨트롤러 내부에서 사용해야 함.
     * @return string
     */
    function viewPrefix()
    {
        return session()->get('agent') . ".";
    }
}
