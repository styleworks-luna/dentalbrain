<?php

namespace App\Services\Notification\Sms;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Ppurio{
    public function getToken() {
        $client = new Client();
        $authorize = base64_encode(env('PPURIO_ID').":".env('PPURIO_SECRET'));
        $result = $client->request('POST', 'https://api.bizppurio.com/v1/token', [
            'headers' => [
                'Authorization' => 'Basic '.$authorize,
                'Content-Type' => 'application/json',
            ]
        ]);
        return json_decode($result->getBody()->getContents(),true);
    }

    public function checkVerification(Request $request){
        $client = new Client();
        $token = $this->getToken();
        $result = $client->request('POST','https://api.bizppurio.com/v3/message',[
           'headers'=>[
               'Authorization' => $token['type']." ".$token['accesstoken'],
               'Content-Type' => 'application/json',
           ],
            'form_params' =>[
                'account' => env('PPURIO_ID'),
                'type' => 'sms',
                'from' => $request->phone,
                'to' => $request->phone,
                'content' => array(
                    "sms" => array(
                        "message" => "Test"
                    )
                ),
                "resend"=>array(
                    "first" => "sms"
                ),
                "recontent" => array(
                    "sms" => array(
                        "message" => "SMS 대체 발송"
                    )
                )
            ]
        ]);

        return json_decode($result->getBody()->getContents(),true);
    }
}