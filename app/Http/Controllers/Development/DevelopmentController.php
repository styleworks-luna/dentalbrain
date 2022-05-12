<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificateCompletion;
use App\Models\Certificate\CertificateQualification;
use App\Models\User;
use App\Models\UserJobName;
use App\Services\Recruit\AbilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevelopmentController extends Controller
{
    /**
     * @var AbilityService
     */
    private $abilityService;

    public function __construct(AbilityService $abilityService)
    {
        $this->abilityService = $abilityService;
    }

    public function pretend(User $user)
    {
        Auth::loginUsingId($user->id);
        return redirect('/');
    }

    public function show(Request $request)
    {
        $data = $request->session()->get('user');

        return view('emails.content')->with(
            [
                "title" => "session",
                "content" => json_encode($data)
            ]
        );
    }

    public function showRegistrationForm()
    {
        return view('desktop.pages.dev.devRegister', [
            'jobs' => UserJobName::query()->orderBy('id')->get()
        ]);
    }

    public function createCertificationQual()
    {
        CertificateQualification::create([
            'title' => 'AAA자격증',
            'certification_number' => '123456',
            'grade' => '1등급',
            'content'=> 'AAA자격증입니다.',
        ]);
    }

    public function createCertificationComp()
    {
        CertificateCompletion::create([
            'title' => 'AAA자격증',
            'content'=> 'AAA자격증 내용.',
            'bottom_content'=> 'AAA자격증 하단내용.',
        ]);
    }
}
