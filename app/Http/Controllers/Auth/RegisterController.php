<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserJob;
use App\Models\UserJobName;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view(viewPrefix() . 'pages.user.register', [
            'jobs' => UserJobName::query()->orderBy('id')->get()
        ]);
    }

    /**
     * Handle a registration request for the application.
     * 기본 회원가입에서 자동 로그인되는 기능만 뺌.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'login_id' => ['required', 'string', 'min:4', 'max:40', 'unique:users'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:40', 'confirmed'],
            'job' => ['required', 'exists:user_job_names,id'],
            'phone' => ['required', 'digits_between:9,11', 'unique:users'],
            'email-consent' => ['nullable'],
            'privacy-consent' => ['accepted'],
            'service-consent' => ['accepted'],
        ])->sometimes('license_num', 'required|min:0|max:40', function ($input) {
            return UserJobName::find($input->job)->need_license == true;
        });
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        // 직업 먼저 생성해야함.
        $license_num = $data['license_num'] ?? null;
        $userJob = UserJob::create([
            'job_name_id' => $data['job'],
            'license_num' => $license_num,
        ]);

        return User::create([
            'login_id' => $data['login_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'api_token' => Str::random(80),
            'job_id' => $userJob->id,
            'allow_email' => isset($data['email-consent']),
        ]);
    }
}
