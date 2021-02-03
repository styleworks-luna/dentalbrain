<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
class SecessionController extends Controller
{
    public function secessionForm()
    {
        return view(viewPrefix() . 'pages.user.mypage.mypage_secession',['user' => Auth::user()]);
    }

    public function userSecession(Request $request)
    {
        if($this->checkPasswordOfCurrentUser($request)){
            Auth::user()->delete();
            return redirect('/')->with('alert','회원 탈퇴 되었습니다.');
        }else{
            return redirect(URL::previous())->with('alert','비밀번호가 일치하지 않습니다.');
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
