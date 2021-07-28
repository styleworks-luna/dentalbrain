<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\Controller;
use App\Mail\Register;
use App\Models\User;
use App\Models\UserJob;
use App\Models\UserJobName;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            ?: redirect($this->redirectPath())->with('alert', '회원가입이 완료되었습니다.');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (env('APP_ENV') != 'production') {
            return $this->inLocalValidation($data);
        }

        /* @see UserController update()
         * @see \App\Http\Controllers\Admin\User\UserController update()
         */
        return Validator::make($data, [
            'login_id' => ['required', 'string', 'min:4', 'max:40', 'unique:users'],
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->where(function ($query) {
                    $query->whereNull('deleted_at')->orWhere('deleted_at', '>', now()->subDays(15));
                })],
            'password' => ['required', 'string', 'min:6', 'max:40',
                'regex:' . User::$passwordPattern,
                // custom validations rule : without_spaces
                'without_spaces',
                'confirmed'],
            'job' => ['required', 'exists:user_job_names,id'],
            'phone' => ['bail', 'required', 'digits_between:9,11',
                Rule::unique('users', 'phone')->where(function ($query) {
                    $query->whereNull('deleted_at')->orWhere('deleted_at', '>', now()->subDays(15));
                })],
            'email-consent' => ['nullable'],
            'sms-consent' => ['nullable'],
            'privacy-consent' => ['accepted'],
            'service-consent' => ['accepted'],
            'verification_number' => ['required', 'string', 'size:6',
                Rule::exists('phone_verifications')->where(function ($query) use ($data) {
                    $query->where('phone', $data['phone'])->where('expired_at', '>', Carbon::now())
                        ->where('verification_number', '=', $data['verification_number']);
                })],
            'work_address' => ['nullable', 'string', 'max:100'],
        ], [
            'email.unique' => '가입 할 수 없는 이메일입니다.',
            'phone.unique' => '가입 할 수 없는 전화번호입니다.',
        ])->sometimes('license_num', 'required|min:0|max:40', function ($input) {
            return UserJobName::find($input->job)->need_license == true;
        });
    }

    private function inLocalValidation($data)
    {
        return Validator::make($data, [
            'login_id' => ['required', 'string', 'min:4', 'max:40', 'unique:users'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->where(function ($query) {
                    $query->whereNull('deleted_at')->orWhere('deleted_at', '>', now()->subDays(15));
                })],
            'password' => ['required', 'string', 'min:6', 'max:40',
                // custom validations rule : without_spaces
                'without_spaces',
                'confirmed'],
            'job' => ['required', 'exists:user_job_names,id'],
            'phone' => ['bail', 'required', 'digits_between:9,11',
                Rule::unique('users', 'email')->where(function ($query) {
                    $query->whereNull('deleted_at')->orWhere('deleted_at', '>', now()->subDays(15));
                })],
            'email-consent' => ['nullable'],
            'sms-consent' => ['nullable'],
            'privacy-consent' => ['accepted'],
            'service-consent' => ['accepted'],
            'verification_number' => ['required', 'string', 'size:6',],
            'work_address' => ['nullable', 'string', 'max:100'],
        ], [
            'email.unique' => '가입 할 수 없는 이메일입니다.',
            'phone.unique' => '가입 할 수 없는 전화번호입니다.',
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
            'allow_sms' => isset($data['sms-consent']),
            'work_address' => $data['work_address'] ?? null,
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        Mail::to($user->email)->send(new Register($user));
    }
}
