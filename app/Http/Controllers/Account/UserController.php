<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserJob;
use App\Models\UserJobName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        /* @see RegisterController validator()
         */
        $data = $request->all();

        $v = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at')->ignore(Auth::id()),],
            'job' => ['required', 'exists:user_job_names,id'],
            'phone' => ['nullable',
                Rule::unique('users', 'phone')->whereNull('deleted_at')->ignore(Auth::id()),],
            'password' => ['nullable', 'string', 'min:6', 'max:40',
                'regex:' . User::$passwordPattern,
                // custom validations rule : without_spaces
                'without_spaces', 'confirmed'],
        ], [
            'email.unique' => '※ 가입 된 이메일입니다.',
            'license_num.*' => '※ 면허번호가 잘못되었습니다.',
            'password.regex' => '※ 비밀번호는 영문 숫자 포함하여 6자 이상입니다.',
        ])->sometimes('license_num', 'required|min:0|max:40', function ($input) {
            // 직업군에 따라 면허번호 필요 여부 다르므로.
            return UserJobName::query()->find($input->job)->need_license == true;
        });

        $needLogout = false;

        $data = $v->validate();
        $license_num = $data['license_num'] ?? null;
        $user = Auth::user();

        try {
            DB::beginTransaction();
            if ($user->job->license_num != $license_num || $user->job->job_name_id != $data['job']) {
                $userJob = UserJob::find($user->job_id);
                $userJob->license_num = $license_num;
                $userJob->job_name_id = $data['job'];
                $userJob->save();
            }
            $user->email = $data['email'];
            if ($data['password'] != null) {
                $user->password = Hash::make($data['password']);
                $needLogout = true;
            }
            if ($data['phone'] != $user->phone) {
                $user->phone = $data['phone'];
                $needLogout = true;
            }
            $user->save();

            DB::commit();
        } catch (\Exception $exception) {
            Log::error('ACCOUNT UPDATE ERROR', [$exception]);
            DB::rollBack();
            return redirect('/')->with('alert', '오류가 발생하였습니다.');
        }

        if ($needLogout) {
            Auth::logout();
            return redirect('/')->with('alert', '변경되었습니다. 다시 로그인 해주세요.');
        }

        return redirect('/')->with('alert', '변경되었습니다.');
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
