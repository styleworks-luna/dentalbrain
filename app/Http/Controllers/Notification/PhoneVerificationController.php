<?php

namespace App\Http\Controllers\Notification;

use App\Models\Notification\PhoneVerification;
use Illuminate\Http\Request;
use App\Services\Notification\Sms\Ppurio;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PhoneVerificationController extends Controller
{
    public function checkVerification(Request $request){
        $validatedData = $request->validate([
            'phone' => 'required|min:10|max:12'
        ]);

        $sms = new Ppurio();
        return $sms->checkVerification($validatedData['phone']);
    }

    public function getVerificationNumber(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:10|max:12',
            'verficationNumber' => 'required|min:6|max:6'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'msg' => '양식에 맞지 않습니다.'
            ]);
        }

        $validatedData = $validator->validate();
        $data = PhoneVerification::query()->where('phone',$validatedData['phone'])->whereDate('expired_at','>',date("Y-m-d H:i:s"))->first();

        if(!empty($data) && $data->verfication_num == $validatedData['verficationNumber']){
            $result = array(
                'success' => true
            );
        }else{
            $result = array(
                'success' => false,
                'msg' => '일치하지 않습니다.'
            );
        }

        return response()->json($result);
    }
}
