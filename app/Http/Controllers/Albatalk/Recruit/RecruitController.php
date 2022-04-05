<?php

namespace App\Http\Controllers\Albatalk\Recruit;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Option\RecruitApplication;
use App\Models\Recruit\Option\RecruitBenefit;
use App\Models\Recruit\Option\RecruitDay;
use App\Models\Recruit\Option\RecruitSalary;
use App\Models\Recruit\Option\TypeApplication;
use App\Models\Recruit\Option\TypeBenefit;
use App\Models\Recruit\Option\TypeDay;
use App\Models\Recruit\Option\TypeJob;
use App\Models\Recruit\Option\TypeSalary;
use App\Models\Recruit\Option\TypeStudy;
use App\Models\Recruit\Option\TypeWork;
use App\Models\Recruit\Recruit;
use App\Services\Recruit\RecruitTemplate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecruitController extends Controller
{
    protected $recruitTemplate;

    public function __construct()
    {
        $this->recruitTemplate = new RecruitTemplate();
    }

    public function createForm()
    {
        return view(viewPrefix() . 'pages.albatalk.albatalk_post')->with([
            'typeApplication' => TypeApplication::all(),
            'typeWork' => TypeWork::all(),
            'typeJob' => TypeJob::all(),
            'typeSalary' => TypeSalary::all(),
            'typeStudy' => TypeStudy::all(),
            'typeDay' => TypeDay::all(),
            'typeBenefit' => TypeBenefit::all(),
        ]);
    }

    public function create(Request $request)
    {
        $data = $this->recruitTemplate->validateRecruit($request);
        session(['data' => $data]);
        $sessionData = $request->session()->get('data');

        $this->recruitTemplate->storeRecruit($sessionData);

        return redirect()->route('albatalk.recruit.payment')->with(['data' => $sessionData]);
    }

    public function payment()
    {
        return view('test');
    }
}
