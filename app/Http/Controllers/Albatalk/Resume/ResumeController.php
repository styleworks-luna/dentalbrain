<?php

namespace App\Http\Controllers\Albatalk\Resume;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Resume\Ability\Ability;
use App\Models\Resume\Ability\AbilityAnswer;
use App\Models\Resume\Ability\AbilityCategory;
use App\Models\Resume\Resume;
use App\Services\File\ResumeThumbnail;
use App\Services\Recruit\AbilityService;
use App\Services\Recruit\ResumeService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
            $resume->file_id = $resumeThumbnail->saveFile($fileValidator->validated()['resume_image'])->id;

            $resume->user_id = Auth::id();

            $resume->save();
        } catch (Exception $exception) {
            report($exception);
            return \redirect(url()->previous())->with('alert', '에러가 발생했습니다. 다시 작성해주세요.');
        }

        return \redirect()->route('albatalk.resume.complete')->with('alert', '등록되었습니다.');
    }

    public function edit(Request $request)
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
            $resume = $this->getLoginUsersResume();
            /** @var Resume $resume */
            $resume->update($resumeValidator->validated());

            $resume->abilityAnswers()->delete();
            $resume->abilityAnswers()->createMany($abilityValidator->validated());

            $resumeThumbnail = new ResumeThumbnail($resume);
            $resumeThumbnail->deleteFile();
            $resume->file_id = $resumeThumbnail->saveFile($fileValidator->validated()['resume_image'])->id;

            $resume->save();
        } catch (Exception $exception) {
            report($exception);
            return \redirect(url()->previous())->with('alert', '에러가 발생했습니다. 다시 작성해주세요.');
        }

        return \redirect()->route('albatalk.resume.complete')->with('alert', '등록되었습니다.');

    }

    public function complete(Request $request)
    {
        try {
            $detail = $this->getDetail();
        } catch (ModelNotFoundException $exception) {
            return \redirect()->back()->with('alert', $exception->getMessage());
        } catch (Exception $exception) {
            return \redirect()->back()->with('alert', '오류가 발생했습니다.');
        }

        return view(viewPrefix() . 'pages.albatalk.albatalk_resume_complete', $detail);
    }

    /**
     * @return array
     * @throws ModelNotFoundException
     */
    public function getDetail(): array
    {
        $resume = $this->getLoginUsersResume();

        if ($resume == null) {
            throw new ModelNotFoundException('이력서를 생성해 주세요.');
        }

        $abilityAnswers = AbilityAnswer::query()
            ->with('ability')
            ->where('resume_id', '=', $resume->id)
            ->get();

        $categories = AbilityCategory::query()->orderBy('seq')
            ->select(['id', 'seq', 'name'])
            ->get()->mapWithKeys(function ($category) {
                return [$category['id'] => $category['name']];
            });

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
            'categories' => $categories,
        ];
    }

    /**
     * @return array
     * @throws ModelNotFoundException
     */
    public function getEdit(): array
    {
        $resume = $this->getLoginUsersResume();

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
     * @return \Closure
     */
    private function createCategoryHeader(int $sum): \Closure
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

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getLoginUsersResume()
    {
        $userId = Auth::id();
        return Resume::query()->with(['file', 'user'])
            ->where('user_id', '=', $userId)
            ->orderBy('created_at', 'desc')->first();
    }
}
