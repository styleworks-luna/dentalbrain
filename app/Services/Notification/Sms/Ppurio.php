<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-02-02
 * Time: 오전 11:14
 */

namespace App\Services\Notification\Sms;

class Ppurio{
    const PpurioID  = 'brainspec';
    const password = 'well5511$$';
    //const url = 'dev-api.bizppurio.com';
    const url = 'https://api.bizppurio.com';

    public function getToken(){
        //curl -u brainspec:well5511$$ -i -H 'Accept:application/json' -X POST https://api.bizppurio.com/v1/token
        print_r('server:'.$_SERVER['SERVER_ADDR']);
        $credentials = base64_encode(self::PpurioID.":".self::password);
        $oCurl = curl_init();
        curl_setopt($oCurl,CURLOPT_URL,self::url.'/v1/token');
        curl_setopt($oCurl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE); //true로 설정시 일부 https 사이트는 안 열림
        curl_setopt($oCurl, CURLOPT_POST, 1);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER,
            array(
                'Content-Type:  application/json; charset=utf-8',
                'Authorization:Basic '.$credentials
            )
        );
        //curl_setopt($oCurl,CURLOPT_USERPWD,$credentials); 이것을 사용하려면 Authorization:Basic을 주석하고 대신 사용
        curl_setopt($oCurl, CURLOPT_VERBOSE, true);
        curl_setopt($oCurl,CURLOPT_NOSIGNAL, 1);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($oCurl);
        print_r(curl_errno($oCurl));
        print_r(curl_error($oCurl));
        curl_close($oCurl);
        print_r('response:'.json_decode($response));
    }
}