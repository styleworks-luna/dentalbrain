<?php

namespace App\Http\Controllers\Albatalk\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Ability\Ability;
use App\Models\Resume\Ability\AbilityCategory;
use App\Models\Resume\Resume;
use App\Services\Recruit\AbilityService;
use App\Services\Recruit\ResumeService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ResumeController extends Controller
{
    /**
     * @var AbilityService
     */
    private $abilityService;
    /**
     * @var ResumeService
     */
    private $resumeService;

    public function __construct(AbilityService $abilityService, ResumeService $resumeService)
    {
        $this->abilityService = $abilityService;
        $this->resumeService = $resumeService;
    }

    public function createForm()
    {
        return view(viewPrefix() . 'pages.albatalk.albatalk_resume')->with([
            'leftList' => AbilityCategory::query()->where('id', '<=', '5')->with('abilities')->get(),
            'rightList' => AbilityCategory::query()->where('id', '>', '5')->with('abilities')->get()
        ]);
    }

    public function create(Request $request)
    {
        $abilityValidator = $this->abilityService->getDefaultRulesOfAbilityAnswers($request->input('abilities'));
        $resumeValidator = $this->resumeService->getValidator($request->input());

        if ($abilityValidator->fails() || $resumeValidator->fails()) {
            $errorBag = $abilityValidator->errors()->merge($resumeValidator->errors());
            return \redirect(url()->previous())
                ->withInput($request->input())
                ->withErrors($errorBag);
        }

        /** @var Resume $resume */
        $resume = Resume::query()->create($resumeValidator->validated());
        $abilityAnswers = $resume->abilityAnswers()->createMany($abilityValidator->validated());

        return \redirect('/')->with('alert', '등록되었습니다.');
    }
}
