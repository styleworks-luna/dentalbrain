<?php

namespace App\Services\Notification\Sms;
use GuzzleHttp\Client;

class Ppurio{
    public function getToken() {
        $client = new Client();
        $authorize = base64_encode(env('PPURIO_ID').":".env('PPURIO_SECRET'));
        $res = $client->request('POST', 'https://api.bizppurio.com/v1/token', [
            'headers' => [
                'Authorization' => 'Basic '.$authorize,
                'Content-Type' => 'application/json',
            ]
        ]);

        return $res;
    }
}