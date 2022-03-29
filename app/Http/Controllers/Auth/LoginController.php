<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view(viewPrefix() . 'pages.user.login');
    }

    public function username()
    {
        return 'login_id';
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->is_admin == false) {
            Auth::logoutOtherDevices($request->password);
        }
        $user->last_login_at = now();
        $user->save();
    }

    protected function validateLogin(Request $request)
    {
        // 로그인 폼 하나도 안채웠을 시 에러 따로 표시해달라는 요청이 있었으므로
        // validation 두개로 분리하여 작성하였음.
        $request->validate([
            $this->username() => 'bail|required|string',
        ]);

        $request->validate([
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login_failed' => [trans('auth.failed')],
        ]);
    }
}
