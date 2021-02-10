<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-02-02
 * Time: 오전 11:14
 */

namespace App\Services\Notification\Sms;
use Illuminate\Support\Facades\Cookie;

class Ppurio{
    const ppurioID  = 'brainspec';
    const password = 'well5511$$';
    //const url = 'https://dev-api.bizppurio.com:10443/';
    //const url = 'https://api.bizppurio.com';
    //$url '
    //curl -u brainspec:well5511$$ -i -H 'Accept:application/json' -H "Content-Type : application/json" -X POST https://dev-api.bizppurio.com:10443/
    //curl_setopt($oCurl, CURLOPT_TIMEOUT, 3);

    public function getToken(){
        $host = 'https://api.bizppurio.com/v1/token';

        $headers = array(
        'Accept: application/json',
        'Content-Type:application/json',
        'Authorization: Basic '. base64_encode(self::ppurioID.":".self::password)
        );

        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_URL, $host);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLOPT_NOSIGNAL, 1);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($oCurl, CURLOPT_VERBOSE, true);

        $response = curl_exec($oCurl);
        $curl_errno = curl_errno($oCurl);
        $curl_error = curl_error($oCurl);

        curl_close($oCurl);

        echo 'Response :';
        echo '<pre>';
        print_r(json_decode($response));
        print_r($curl_error);
        echo '</pre>';
    }
}