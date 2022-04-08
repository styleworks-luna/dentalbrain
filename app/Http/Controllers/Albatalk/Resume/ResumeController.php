<?php

namespace App\Http\Controllers\Albatalk\Resume;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Resume\Ability\Ability;
use App\Models\Resume\Ability\AbilityCategory;
use App\Models\Resume\Resume;
use App\Services\File\ResumeThumbnail;
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
        $resumeValidator = $this->resumeService->getResumeValidator($request->all());
        $fileValidator = $this->resumeService->getFileValidator($request);

        if ($abilityValidator->fails() || $resumeValidator->fails() || $fileValidator->fails()) {
            $errorBag = $abilityValidator->errors()
                ->merge($resumeValidator->errors())
                ->merge($fileValidator->errors());

            return \redirect(url()->previous())
                ->withInput($request->input())
                ->withErrors($errorBag);
        }

        try {
            /** @var Resume $resume */
            $resume = Resume::query()->create($resumeValidator->validated());
            $abilityAnswers = $resume->abilityAnswers()->createMany($abilityValidator->validated());
            $resumeThumbnail = new ResumeThumbnail($resume);
            $resumeThumbnail->saveFile($fileValidator->validated());
        } catch (\Exception $exception) {
            return \redirect(url()->previous())->with('alert','에러가 발생했습니다. 다시 작성해주세요.');
        }

        return \redirect('/')->with('alert', '등록되었습니다.');
    }
}
