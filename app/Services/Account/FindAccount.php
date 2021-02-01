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
use Illuminate\Support\Facades\Hash;

class FindAccount{
    public function findId(Request $request){
        $validatedData = $request->validate([
            'login_id' => 'required'
        ]);

        $user = User::where('login_id',$validatedData['login_id'])->first();
        return isset($user) && !empty($user);
    }

    public function findIdWithNameAndPhone(Request $request){
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

    public function checkPasswordOfCurrentUser(Request $request){
        $validatedData = $request->validate([
            'password' => 'required| min:6'
        ]);

        if(Hash::check($validatedData['password'], auth()->user()->password)){
            return true;
        }else{
            return false;
        }
    }
}