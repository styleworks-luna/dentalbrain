<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-02-05
 * Time: 오전 10:40
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\Reset;
use App\Models\Password\PasswordReset;


class FindPasswordController extends Controller{
    public function sendPasswordMail(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);

        $passwordReset = new PasswordReset();
        $passwordReset->email = $validatedData['email'];
        $passwordReset->remember_token = Str::random(60);
        $passwordReset->created_at = now();
        $passwordReset->save();

        return $this->sendResetEmail($passwordReset);
    }

    private function sendResetEmail($passwordReset){
        try{
            $user = User::where('email', $passwordReset->email)->firstOrFail();
        }catch(\Exception $e){
            return redirect()->back()->with('alert','해당 이메일로 가입한 아이디가 없습니다.');
        }

        $link = config('app.url').'/password/reset/'.$passwordReset->remember_token.'?email='.urlencode($passwordReset->email);
        try{
            Mail::to($passwordReset->email)
                ->send(new Reset($user,$link));
            return redirect()->back()->with('alert', "패스워드 재설정 메일이 전송되었습니다");
        }catch(\Exception $e){
            return redirect()->back()->with('alert', "메일 전송 오류");
        }
    }

    public function showPasswordResetForm($token){
        $tokenData = PasswordReset::where('remember_token', $token)->first();

        if ( !$tokenData ) return redirect()->to('/');
        return view(viewPrefix() .'pages.passwords.show',['token'=> $token]);
    }

    public function resetPassword(Request $request, $token){
        $password = $request->password;
        $tokenData = PasswordReset::where('remember_token',$token)->first();

        $user = User::where('email',$tokenData->email)->first();
        if( !$user) return redirect()->to('/');

        $user->password = Hash::make($password);
        $user->update();

        Auth::login($user);

        PasswordReset::where('email',$user->email)->delete();

        return redirect()->to('/')->with('alert','비밀번호를 변경하였습니다.');
    }
}