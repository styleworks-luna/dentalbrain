<?php

namespace App\Http\Controllers\Albatalk\Recruit;

use App\DTO\Recruit\RecruitAuthority;
use App\Http\Controllers\Controller;
use App\Models\Recruit\Option\RecruitApplication;
use App\Models\Recruit\Option\RecruitBenefit;
use App\Models\Recruit\Option\RecruitDay;
use App\Models\Recruit\Option\RecruitSalary;
use App\Models\Recruit\Recruit;
use App\Models\Resume\Ability\AbilityAnswer;
use App\Models\Resume\Ability\AbilityCategory;
use App\Models\Resume\AppliedResume;
use App\Models\User;
use App\Services\Recruit\ApplyService;
use App\Services\Recruit\ResumeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class RecruitDetailController extends Controller
{
    private $resumeService;
    private $applyService;

    public function __construct(ResumeService $resumeService, ApplyService $applyService)
    {
        $this->resumeService = $resumeService;
        $this->applyService = $applyService;
    }


    public function detail(Recruit $recruit)
    {
        $applications = RecruitApplication::query()->where('recruit_id', '=', $recruit->id)->get();
        $salaries = RecruitSalary::query()->where('recruit_id', '=', $recruit->id)->get();
        $days = RecruitDay::query()->where('recruit_id', '=', $recruit->id)->get();
        $benefits = RecruitBenefit::query()->where('recruit_id', '=', $recruit->id)->get();

        $recruit->with('typeWork', 'typeJob', 'typeStudy', 'file', 'file1', 'file2', 'file3');

        if (Auth::check()) {
            $authority = new RecruitAuthority($recruit, $this->applyService->applied($recruit));
        } else {
            $authority = new RecruitAuthority($recruit, false);
        }

        if ($authority->isAdmin() || $authority->isOwner()) {
            $appliedResumes = AppliedResume::query()
                ->where('recruit_id', '=', $recruit->id)
                ->orderByDesc('applied_at')
                ->with('resume.user')
                ->get();
        } else {
            $appliedResumes = collect();
        }

        return view(viewPrefix() . 'pages.albatalk.albatalk_detail', [
            'recruit' => $recruit,
            'applications' => $applications,
            'salaries' => $salaries,
            'days' => $days,
            'benefits' => $benefits,
            'authority' => $authority,
            'appliedResumes' => $appliedResumes,
        ]);
    }

    public function apply(Recruit $recruit)
    {
        try {
            $this->applyService->apply($recruit);
        } catch (ModelNotFoundException $exception) {
            report($exception);
            return back()
                ->with('alert', '이력서가 없습니다.');
        }


        return redirect()
            ->route('albatalk.recruit.detail', $recruit->id)
            ->with('alert', '제출되었습니다.');
    }

    public function pdf(Recruit $recruit, User $user)
    {
        try {
            $appliedResume = $this->applyService->findApplied($recruit, $user);

            if ($appliedResume == null) {
                throw new ModelNotFoundException('이력서를 생성해 주세요.');
            }

            $pdf = $this->resumeService->getPdf($appliedResume->resume);
            return $pdf->stream('resume.pdf');

        } catch (ModelNotFoundException $exception) {
            return \redirect()->back()->with('alert', $exception->getMessage());
        } catch (\Exception $exception) {
            return \redirect()->back()->with('alert', '오류가 발생했습니다.');
        }
    }
}
