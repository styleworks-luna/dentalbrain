<?php

namespace App\Http\Controllers\Albatalk\Resume;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Resume\Ability\AbilityAnswer;
use App\Models\Resume\Ability\AbilityCategory;
use App\Models\Resume\Resume;
use App\Services\File\ResumeThumbnail;
use App\Services\Recruit\AbilityService;
use App\Services\Recruit\ResumeService;
use Closure;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Jenssegers\Agent\Facades\Agent;

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

    public function resumeIndex()
    {
        if ($this->resumeService->existsResume()) {
            return $this->completeForm();
        }

        if (Agent::isMobile()) {
            return back()->with(['alert' => 'PC에서만 작성해 주세요.']);
        }

        return view('desktop.pages.albatalk.albatalk_resume')->with([
            'leftList' => AbilityCategory::query()->where('id', '<=', '5')->with('abilities')->get(),
            'rightList' => AbilityCategory::query()->where('id', '>', '5')->with('abilities')->get()
        ]);
    }

    public function create(Request $request)
    {
        $abilityValidator = $this->abilityService->getDefaultRulesOfAbilityAnswers($request->input('abilities'));
        $resumeValidator = $this->resumeService->getResumeValidator($request->all());

        if ($abilityValidator->fails() || $resumeValidator->fails()) {
            $errorBag = $abilityValidator->errors()
                ->merge($resumeValidator->errors());

            return \redirect(url()->previous())
                ->withInput($request->input())
                ->withErrors($errorBag);
        }

        try {
            /** @var Resume $resume */
            $resumeData = $resumeValidator->validated();

            $resume = Resume::query()->create($resumeData);

            $file = File::query()->find($resumeData['file_id']);
            $resumeThumbnail = new ResumeThumbnail($resume);
            $resumeThumbnail->moveTempToPublic($file);

            $resume->user_id = Auth::id();
            $resume->save();

            $resume->abilityAnswers()->createMany($abilityValidator->validated());
        } catch (Exception $exception) {
            report($exception);
            return \redirect(url()->previous())->with('alert', '에러가 발생했습니다. 다시 작성해주세요.');
        }

        return \redirect()->route('albatalk.resume.index')->with('alert', '등록되었습니다.');
    }

    public function edit()
    {
        try {
            $editForm = $this->getEdit();
        } catch (ModelNotFoundException $exception) {
            return \redirect()->back()->with('alert', $exception->getMessage());
        } catch (Exception $exception) {
            return \redirect()->back()->with('alert', '오류가 발생했습니다.');
        }

        return view(viewPrefix() . 'pages.albatalk.albatalk_resume_edit', $editForm);
    }

    public function update(Request $request)
    {
        $abilityValidator = $this->abilityService->getDefaultRulesOfAbilityAnswers($request->input('abilities'));
        $resumeValidator = $this->resumeService->getResumeValidator($request->all());

        if ($abilityValidator->fails() || $resumeValidator->fails()) {
            $errorBag = $abilityValidator->errors()
                ->merge($resumeValidator->errors());

            return \redirect(url()->previous())
                ->withInput($request->input())
                ->withErrors($errorBag);
        }

        try {
            /** @var Resume $resume */
            $resume = $this->resumeService->getLoginUsersResume();
            $resumeData = $resumeValidator->validated();

            if ($resume->file == null || $resume->file->id != $resumeData['file_id']) {
                $resumeThumbnail = new ResumeThumbnail($resume);
                $resumeThumbnail->deleteFile();

                $file = File::query()->find($resumeData['file_id']);
                $resumeThumbnail->moveTempToPublic($file);
            }

            $resume->update($resumeData);

            $resume->abilityAnswers()->delete();
            $resume->abilityAnswers()->createMany($abilityValidator->validated());

            $resume->save();
        } catch (Exception $exception) {
            report($exception);
            return \redirect(url()->previous())->with('alert', '에러가 발생했습니다. 다시 작성해주세요.');
        }

        return \redirect()->route('albatalk.resume.index')->with('alert', '등록되었습니다.');

    }

    private function completeForm()
    {
        try {
            $resume = $this->resumeService->getLoginUsersResume();

            if ($resume == null) {
                throw new ModelNotFoundException('이력서를 생성해 주세요.');
            }

            $abilityAnswers = AbilityAnswer::onResume($resume)->get();

            $categories = AbilityCategory::query()->orderBy('seq')
                ->select(['id', 'seq', 'name'])
                ->get()
                ->mapWithKeys(function ($category) {
                    return [$category['id'] => $category['name']];
                });

            $leftList = $abilityAnswers->filter(function ($answer) {
                return $answer->ability->category_id <= 5;
            });

            $rightList = $abilityAnswers->filter(function ($answer) {
                return $answer->ability->category_id > 5;
            });

        } catch (ModelNotFoundException $exception) {
            return \redirect()->back()->with('alert', $exception->getMessage());
        } catch (Exception $exception) {
            return \redirect()->back()->with('alert', '오류가 발생했습니다.');
        }

        return view(viewPrefix() . 'pages.albatalk.albatalk_resume_complete', [
            'resume' => $resume,
            'leftList' => $leftList,
            'rightList' => $rightList,
            'categories' => $categories,
        ]);
    }

    /**
     * @return array
     * @throws ModelNotFoundException
     */
    private function getEdit(): array
    {
        $resume = $this->resumeService->getLoginUsersResume();

        if ($resume == null) {
            throw new ModelNotFoundException('이력서를 생성해 주세요.');
        }

        $categoryHeaders = AbilityCategory::query()->orderBy('seq')
            ->withCount('abilities')
            ->get();

        $sum = 0;
        $leftCategoryHeaders = $categoryHeaders->filter(function ($category) {
            return $category->id <= 5;
        })->mapWithKeys($this->createCategoryHeader($sum));

        $sum = 0;
        $rightCategoryHeaders = $categoryHeaders->filter(function ($category) {
            return $category->id > 5;
        })->mapWithKeys($this->createCategoryHeader($sum));

        $abilityAnswers = AbilityAnswer::query()
            ->with('ability')
            ->where('resume_id', '=', $resume->id)
            ->get();

        $leftList = $abilityAnswers->filter(function ($answer) {
            return $answer->ability->category_id <= 5;
        });

        $rightList = $abilityAnswers->filter(function ($answer) {
            return $answer->ability->category_id > 5;
        });

        return [
            'resume' => $resume,
            'leftList' => $leftList,
            'rightList' => $rightList,
            'leftCategoryHeaders' => $leftCategoryHeaders,
            'rightCategoryHeaders' => $rightCategoryHeaders,
        ];
    }

    /**
     * @param int $sum
     * @return Closure
     */
    private function createCategoryHeader(int $sum): Closure
    {
        return function ($category) use (&$sum) {
            $index = $sum;
            $sum = $sum + $category['abilities_count'];
            return [
                $category['id'] => [
                    'name' => $category['name'],
                    'loopIndex' => $index,
                    'rowspan' => $category['abilities_count'],
                ]
            ];
        };
    }
}
