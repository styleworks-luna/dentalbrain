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
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecruitController extends Controller
{
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
        $data = $request->validate([
            'company_name' => ['required', 'string', 'min:2', 'max:255'],
            'company_leader' => ['required', 'string', 'max:255'],
            'company_license' => ['required', 'string', 'max:255'],
            'company_phone' => ['required', 'numeric', 'digits_between:9,11'],

            'name' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'numeric', 'digits_between:9,11'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'url' => ['required', 'url'],
            'subway' => ['nullable', 'string', 'max:255'],

            'application' => ['required'],
            'work' => ['required', Rule::in([TypeWork::$TYPE_WORK_1, TypeWork::$TYPE_WORK_2, TypeWork::$TYPE_WORK_3])],
            'job' => ['required', Rule::in([TypeJob::$TYPE_JOB_1, TypeJob::$TYPE_JOB_2, TypeJob::$TYPE_JOB_3, TypeJob::$TYPE_JOB_4, TypeJob::$TYPE_JOB_5])],
            'salary' => ['required', Rule::in([TypeSalary::$TYPE_SALARY_1, TypeSalary::$TYPE_SALARY_2, TypeSalary::$TYPE_SALARY_3, TypeSalary::$TYPE_SALARY_4])],
            'salary_value' => ['nullable', Rule::requiredIf($request->salary == TypeSalary::$TYPE_SALARY_4)],
            'study' => ['required', 'digits_between:1,13'],
            'career' => ['required', 'numeric', 'digits_between:0, 30'],
            'day' => ['required', Rule::in([TypeDay::$TYPE_DAY_1, TypeDay::$TYPE_DAY_2, TypeDay::$TYPE_DAY_3, TypeDay::$TYPE_DAY_4])],
            'day_value' => ['nullable', Rule::requiredIf($request->day == TypeDay::$TYPE_DAY_4)],
            'benefit' => ['required'],

            'started_at' => ['required', 'date_format:Y-m-d'],
            'ended_at' => ['required', 'date_format:Y-m-d', 'after:started_at'],
            'content' => ['nullable'],
        ]);

        // 구인 등록
        $recruit = Recruit::create([
            'user_id' => auth()->id(),
            'company_name' => $data['company_name'],
            'company_leader' => $data['company_leader'],
            'company_license' => $data['company_license'],
            'company_phone' => $data['company_phone'],

            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'url' => $data['url'],
            'subway' => $data['subway'],

            'address' => "서울 송파구 오금동",
            'address_detail' => "아남아파트",
            'sido' => "서울",
            'gugun' => '송파구',
            'dong' => '오금동',
            'latitude' => '37.50416961685561',
            'longitude' => '127.02096038259408',

            'type_work_id' => $data['work'],
            'type_job_id' => $data['job'],
            'type_study_id' => $data['study'],
            'career' => $data['career'],

            'started_at' => $data['started_at'],
            'ended_at' => $data['ended_at'],
            'content' => $data['content'],
        ]);

        // 신청분야 다중 선택값 넣기
        $application = RecruitApplication::where('recruit_id', '=', $recruit->id)->first();
        if (!$application) {
            foreach($data['application'] as $key => $value) {
                RecruitApplication::create([
                    'type' => TypeApplication::find($key)['type'],
                    'recruit_id' => $recruit->id,
                    'type_application_id' => $key,
                ]);
            }
        }

        // 급여
        $salary = RecruitSalary::where('recruit_id', '=', $recruit->id)->first();
        if (!$salary) {
            RecruitSalary::create([
                'type' => TypeSalary::find($data['salary'])['type'],
                'value' => $data['salary_value'],
                'recruit_id' => $recruit->id,
                'type_salary_id' => $data['salary'],
            ]);
        }

        // 근무요일
        $day = RecruitDay::where('recruit_id', '=', $recruit->id)->first();
        if (!$day) {
            RecruitDay::create([
                'type' => TypeDay::find($data['day'])['type'],
                'value' => $data['day_value'],
                'recruit_id' => $recruit->id,
                'type_day_id' => $data['day'],
            ]);
        }

        // 복리후생 다중 선택값 넣기
        $benefit = RecruitBenefit::where('recruit_id', '=', $recruit->id)->first();
        if (!$benefit) {
            foreach($data['benefit'] as $key => $value) {
                RecruitBenefit::create([
                    'type' => TypeBenefit::find($key)['type'],
                    'recruit_id' => $recruit->id,
                    'type_benefit_id' => $key,
                ]);
            }
        }

        ddd($request->request);

//        return redirect()->route('albatalk.payment');
    }
}
