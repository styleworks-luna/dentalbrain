<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-28
 * Time: 오후 1:39
 */

namespace App\Services\Account;

use Illuminate\Http\Request;
use App\Models\User;

class FindAccount{
    public function findId(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required | numeric'
        ]);

        $user = User::where('name',$validatedData['name'])->where('phone',$validatedData['phone'])->first();
        if(isset($user)){
            return response()->json(['message'=>'가입된 아이디는 "'.$user->login_id.'" 입니다.','success' => true]);
        }else{
            return response()->json(['message'=>'해당 정보와 일치하는 아이디가 없습니다.','success' => false]);
        }
    }
}