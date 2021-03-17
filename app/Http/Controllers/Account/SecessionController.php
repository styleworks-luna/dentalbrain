<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Mail\Secession;
use App\Models\Payments\Payment;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use App\Models\UserSecession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SecessionController extends Controller
{
    public function secessionForm()
    {
        return view(viewPrefix() . 'pages.user.mypage.mypage_secession', ['user' => Auth::user()]);
    }

    public function userSecession(Request $request)
    {

        $validator = Validator::make($request->except('_token'), [
            'password' => 'required | min:6',
            'secession-radio' => 'required'
        ])->sometimes('secession-reason', 'required', function ($input) {
            return $input->get('secession-radio') == '기타';
        });

        $validatedData = $validator->validate();

        if ($this->checkPasswordOfCurrentUser($validatedData['password'])) {
            try {
                DB::beginTransaction();
                if(Auth::user()->is_admin == false) {
                    $userSecession = new UserSecession();
                    $userSecession->user_id = Auth::id();
                    $userSecession->reason = isset($validatedData['secession-reason']) ? $validatedData['secession-reason'] : $validatedData['secession-radio'];
                    $userSecession->save();

                    $user = User::find(Auth::id());

                    $user->surveyAnswers()->delete();
                    $user->lectureQuestions()->delete();
                    $user->likes()->delete();
                    $user->comments()->delete();

                    $programStudent = ProgramStudent::query()->where('user_id',Auth::id());
                    foreach($programStudent->get() as $student){
                        Payment::find($student->payment_id)->delete();
                    }
                    $programStudent->delete();
                    DB::commit();
                }else{
                    DB::rollBack();
                    return redirect()->back()->with('alert','관리자는 회원 탈퇴가 불가능합니다.');
                }
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('USER SECESSION ERROR',[$exception]);
                return redirect()->back()->with('alert','에러가 발생했습니다.');
            }
            //TODO : 회원 탈퇴 시 남아있는 회원 정보들을 모두 지워야 함.

            Mail::to(Auth::user()->email)->send(new Secession(Auth::user(), $userSecession));
            Auth::user()->delete();
            return redirect('/')->with('alert', '회원 탈퇴 되었습니다.');
        } else {
            throw ValidationException::withMessages([
                'password_wrong' => '※ 비밀번호가 일치하지 않습니다.',
            ]);
            return redirect()->back();
        }
    }

    public function checkPasswordOfCurrentUser($password)
    {
        return (Hash::check($password, auth()->user()->password)) ? true : false;
    }
}
