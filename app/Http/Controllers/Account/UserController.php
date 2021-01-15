<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\UserJob;
use App\Models\UserJobName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('password.confirm:account.confirm')->except('confirm', 'needConfirm');
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
            return $input->job <= 2;
        });
        $data = $v->validate();

        $user = Auth::user();

        if ($user->job->license_num != $data['license_num'] || $user->job->job_id != $data['job']) {
            $license_num = $data['license_num'] ?? null;
            $newUserJob = UserJob::create([
                'job_name_id' => $data['job'],
                'license_num' => $license_num,
            ]);
            $user->job->delete();
            $user->job_id = $newUserJob->id;
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
}
