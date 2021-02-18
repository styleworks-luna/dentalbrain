<?php

namespace App\Services\Notification\Sms;
use App\Models\Notification\PhoneVerification;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function checkVerification($phoneNumber){
        $token = $this->getToken();
        $verification_num = str_pad(mt_rand(0,999999),6,'0');
        $message = "문자 인증번호: ".$verification_num;
        $sms = array("message" => $message);
        $content = array("sms" => $sms);

        $data =array();
        $data['account'] = env('PPURIO_ID');
        $data['refkey']=Str::random('10');
        $data['type'] = "sms";
        $data['from'] = env('PPURIO_PHONE');
        $data['to'] = $phoneNumber;
        $data['content'] = $content;

        $json_data = json_encode($data,JSON_UNESCAPED_SLASHES);

        $url = 'https://api.bizppurio.com/v3/message';

        $oCurl = curl_init();
        curl_setopt($oCurl,CURLOPT_URL,$url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1); //result로 true, false 대신 해당 값들을 return함.
        curl_setopt($oCurl, CURLOPT_NOSIGNAL, 1);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, array('Accept:application/json','Content-Type:application/json','Authorization:'.$token['type']." ".$token['accesstoken']));
        curl_setopt($oCurl, CURLOPT_VERBOSE, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 3);

        $response = curl_exec($oCurl);

        try{
            DB::beginTransaction();
            var_dump(json_decode($response,true));
            if(json_decode($response,true)['code'] == '1000'){
                PhoneVerification::query()->updateOrCreate(
                    ['phone'=> $phoneNumber,'verfication_num'=> $verification_num, 'expired_at'=> $token['expired']]
                );
                DB::commit();
            }
        }catch(\Exception $exception){
            Log::error('CREATE PPURIO CHECKVERIFICATION ERROR',[$exception]);
            DB::rollBack();
        }
        curl_close($oCurl);
        return json_decode($response,true);
    }
}