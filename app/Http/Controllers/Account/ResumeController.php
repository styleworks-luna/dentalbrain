<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Resume\Ability\AbilityAnswer;
use App\Models\Resume\Ability\AbilityCategory;
use App\Models\Resume\AppliedResume;
use App\Models\Resume\Resume;
use App\Services\Recruit\ResumeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Jenssegers\Agent\Facades\Agent;

class ResumeController extends Controller
{
    private $resumeService;

    public function __construct(ResumeService $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    public function mypageResume()
    {
        $resume = $this->resumeService->getLoginUsersResume();

        return Agent::isMobile() ?
            $this->myPageResumeMobile($resume) : $this->myPageResumeDesktop($resume);
    }

    /**
     * @param null|Resume|Model $resume
     * @return Application|Factory|View
     */
    private function myPageResumeMobile($resume = null)
    {
        if ($resume == null) {
            return view('mobile.pages.user.mypage.mypage_albatalk_resume', [
                'resume' => null,
            ]);
        }
        $categories = AbilityCategory::query()->orderBy('seq')
            ->select(['id', 'seq', 'name'])
            ->with('abilities')
            ->get();

        $answers = AbilityAnswer::onResume($resume)
            ->get()
            ->mapWithKeys(function ($answer) {
                return [$answer['ability_id'] => [
                    'content' => $answer['content'],
                    'score' => $answer['score'],
                    'can_learn' => $answer['can_learn'],
                ]];
            });

        return view('mobile.pages.user.mypage.mypage_albatalk_resume', [
            'resume' => $resume,
            'categories' => $categories,
            'answers' => $answers,
        ]);
    }

    /**
     * @param null|Model|Resume $resume
     * @return Application|Factory|RedirectResponse|View
     */
    private function myPageResumeDesktop($resume = null)
    {
        if ($resume == null) {
            return view('desktop.pages.user.mypage.mypage_albatalk_resume', [
                'resume' => null,
            ]);
        }

        try {
            $categories = AbilityCategory::query()->orderBy('seq')
                ->select(['id', 'seq', 'name'])
                ->get()->mapWithKeys(function ($category) {
                    return [$category['id'] => $category['name']];
                });

            $abilityAnswers = AbilityAnswer::onResume($resume)->get();

            $leftList = $abilityAnswers->filter(function ($answer) {
                return $answer->ability->category_id <= 5;
            });

            $rightList = $abilityAnswers->filter(function ($answer) {
                return $answer->ability->category_id > 5;
            });

        } catch (ModelNotFoundException $exception) {
            return \redirect()->back()->with('alert', $exception->getMessage());
        } catch (\Exception $exception) {
            return \redirect()->back()->with('alert', '오류가 발생했습니다.');
        }

        return view('desktop.pages.user.mypage.mypage_albatalk_resume', [
            'resume' => $resume,
            'leftList' => $leftList,
            'rightList' => $rightList,
            'categories' => $categories,
        ]);
    }

    public function appliedResumeList(Request $request)
    {
        /** @var Resume $resume */
        $resume = Resume::query()->where('user_id', '=', Auth::id())->first();
        if ($resume == null) {
            return response()->json([]);
        }
        $appliedResumes = $resume->appliedResumes()
            ->select(['id', 'recruit_id', 'resume_id', 'status', 'applied_at', 'is_recommended'])
            ->with(['recruit' => function ($query) {
                $query->with('file:id,url')
                    ->select(['id', 'main_file_id', 'company_name', 'sido', 'gugun', 'dong']);
            }])
            ->where('status', '=', AppliedResume::STATUS_SUCCESS)
            ->orderByDesc('applied_at')
            ->get();
        return response()->json($appliedResumes->toArray());
    }
}
