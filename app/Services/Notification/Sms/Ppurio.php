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
    const PpurioID  = 'brainspec';
    const password = 'well5511$$';
    //const url = 'https://dev-api.bizppurio.com:10443/';
    //const url = 'https://api.bizppurio.com';
    //$url '
    public function getToken(){
        //curl -u brainspec:well5511$$ -i -H 'Accept:application/json' -H "Content-Type : application/json" -X POST https://dev-api.bizppurio.com:10443/
        //curl_setopt($oCurl, CURLOPT_TIMEOUT, 3);

        $url = 'https://dev-api.bizppurio.com:443/v1/token';
        $credentials = base64_encode(self::PpurioID.":".self::password);
        $oCurl = curl_init();
        curl_setopt($oCurl,CURLOPT_URL,$url);
        curl_setopt($oCurl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl,CURLOPT_NOSIGNAL, 1);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false); //true로 설정시 일부 https 사이트는 안 열림
        curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($oCurl,CURLOPT_HEADER,1);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER,
            array(
                'Accept : application/json',
                'Content Type: application/json',
                'Authorization:Basic '.$credentials
            )
        );
        curl_setopt($oCurl, CURLOPT_VERBOSE, true);
        curl_setopt($oCurl, CURLOPT_POST, true);

        $header_size = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);

        $response = curl_exec($oCurl);
        $curl_errno = curl_errno($oCurl);
        $curl_error = curl_error($oCurl);

        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        print_r('<br/>header:'.$header);
        print_r('<br/>body:'.$body);
        curl_close($oCurl);
        print_r('<br/>result:'.$response);

        echo '<pre>';
        print_r(json_decode($response));
        print_r($curl_error);
        echo '</pre>';
    }
}