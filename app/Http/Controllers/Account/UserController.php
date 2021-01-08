<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('password.confirm:account.confirm')->except('confirm', 'needConfirm');
    }

    public function modify()
    {
        return '준비중입니다.';
    }

    public function needConfirm(Request $request)
    {
        return view(viewPrefix() . 'pages.user.confirm');
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
