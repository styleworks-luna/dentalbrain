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
        var_dump(is_array($token));
        var_dump($token);
        $result = $client->request('POST','https://api.bizppurio.com/v3/message',[
           'headers'=>[
               'Authorization' => $token['type']." ".$token['accesstoken'],
               'Content-Type' => 'application/json',
           ],
            'form_params' =>[
                'account' => env('PPURIO_ID'),
                'type' => 'SMS',
                'from' => $request->phone,
                'to' => $request->phone,
                'content' => Str::random('6'),
                'phone' => $request->phone
            ]
        ]);

        return $result;
    }
}