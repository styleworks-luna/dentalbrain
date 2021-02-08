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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\Reset;


class FindPasswordController extends Controller{
    public function sendPasswordMail(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);

        return $this->sendResetEmail($validatedData['email']);
    }

    private function sendResetEmail($email){
        try{
            $user = User::where('email', $email)->firstOrFail();
            $newPassword = Str::random(6);
            DB::beginTransaction();
            $user->password = Hash::make($newPassword);
            $user->save();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('alert','해당 이메일로 가입한 아이디가 없습니다.');
        }

        try{
            Mail::to($email)
                ->send(new Reset($user,$newPassword));
            return redirect()->back()->with('alert', "패스워드 재설정 메일이 전송되었습니다");
        }catch(\Exception $e){
            return redirect()->back()->with('alert', "메일 전송 오류");
        }
    }
}