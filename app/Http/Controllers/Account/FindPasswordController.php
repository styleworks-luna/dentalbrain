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

            return response()->json([
                'message' => '존재하지 않는 이메일 입니다',
                'success' => false
            ]);
        }

        try{
            Mail::to($email)
                ->send(new Reset($user,$newPassword));

            return response()->json([
                'message' => '회원님의 메일로 비밀번호 재설정 안내 메일이 발송되었습니다.',
                'success' => true
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => '오류가 발생했습니다.',
                'success' => false
            ]);
        }
    }

    public function sendPasswordMailWithUser(User $user){
        return $this->sendResetEmail($user->email);
    }
}