<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserJob;
use App\Models\UserJobName;
use App\Services\Account\FindAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('password.confirm:account.confirm')->except('confirm', 'needConfirm','findId','findIdWithNameAndPhone');
    }

    public function modify()
    {
        return view(viewPrefix() . 'pages.user.mypage.mypage_edit')->with([
            'categories' => UserJobName::query()->select('id', 'name')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'max:40', 'confirmed'],
            'job' => ['required', 'min:0', 'max:5'],
            'phone' => ['required'],
        ])->sometimes('license_num', 'required|min:0|max:40', function ($input) {
            // 직업군에 따라 면허번호 필요 여부 다르므로.
            return UserJobName::find($input->job)->need_license == true;
        });
        $data = $v->validate();
        $license_num = $data['license_num'] ?? null;
        $user = Auth::user();

        if ($user->job->license_num != $license_num || $user->job->job_name_id != $data['job']) {
            $userJob = UserJob::find($user->job_id);
            $userJob->license_num = $license_num;
            $userJob->job_name_id = $data['job'];
            $userJob->save();
        }

        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->phone = $data['phone'];
        $user->save();

        Auth::logout();

        return redirect('/')->with('alert','변경되었습니다. 다시 로그인 해주세요.');
    }

    public function needConfirm(Request $request)
    {
        return view(viewPrefix() . 'pages.user.mypage.mypage_login');
    }

    public function confirm(Request $request)
    {
        $data = $request->validate([
            'password' => ['required']
        ]);
        $data['login_id'] = Auth::user()->login_id;

        if (Auth::attempt($data)) {
            $request->session()->put('auth.password_confirmed_at', time());
            return response()->redirectToIntended();
        }

        return response()->redirectToRoute('account.modify');
    }


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

}
