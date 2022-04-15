<?php

namespace App\Http\Controllers\Albatalk\Recruit;

use App\DTO\Recruit\RecruitAuthority;
use App\Http\Controllers\Controller;
use App\Models\Recruit\Option\RecruitApplication;
use App\Models\Recruit\Option\RecruitBenefit;
use App\Models\Recruit\Option\RecruitDay;
use App\Models\Recruit\Option\RecruitSalary;
use App\Models\Recruit\Recruit;
use App\Services\Recruit\ApplyService;
use App\Services\Recruit\ResumeService;
use Illuminate\Http\Request;
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
            $authority = new RecruitAuthority($recruit->user_id == Auth::id(), $this->applyService->applied($recruit), Auth::user()->is_admin);
        } else {
            $authority = new RecruitAuthority(false, false);
        }

        return view(viewPrefix() . 'pages.albatalk.albatalk_detail', [
            'recruit' => $recruit,
            'applications' => $applications,
            'salaries' => $salaries,
            'days' => $days,
            'benefits' => $benefits,
            'authority' => $authority,
        ]);
    }

    public function apply(Recruit $recruit)
    {
        $this->applyService->apply($recruit);

        return redirect()
            ->route('albatalk.recruit.detail', $recruit->id)
            ->with('alert', '제출되었습니다.');
    }
}
