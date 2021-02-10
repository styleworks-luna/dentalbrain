<?php

$host = 'https://api.bizppurio.com/v1/token';
//$host = 'https://dev-api.bizppurio.com/v1/token';

$headers = array(
    'Accept: application/json',
    'Content-Type:application/json',
    'Authorization: Basic '. base64_encode("brainspec:well5511$$")
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
?>