<?php

namespace App\Http\Controllers\Albatalk\Recruit;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Option\RecruitApplication;
use App\Models\Recruit\Option\RecruitBenefit;
use App\Models\Recruit\Option\TypeApplication;
use App\Models\Recruit\Option\TypeBenefit;
use App\Models\Recruit\Option\TypeDay;
use App\Models\Recruit\Option\TypeJob;
use App\Models\Recruit\Option\TypeSalary;
use App\Models\Recruit\Option\TypeWork;
use App\Models\Recruit\Recruit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecruitController extends Controller
{
    public function payment()
    {
        return view('test');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
//            'company_name' => ['required', 'string', 'min:2', 'max:255'],
//            'company_leader' => ['required', 'string', 'max:255'],
//            'company_license' => ['required', 'string', 'max:255'],
//            'company_phone' => ['required', 'numeric', 'digits_between:9,11'],
//
//            'name' => ['required', 'string', 'min:2', 'max:100'],
//            'phone' => ['required', 'numeric', 'digits_between:9,11'],
//            'email' => ['required', 'string', 'email', 'max:255'],
//            'url' => ['required', 'url'],
//            'subway' => ['nullable', 'string', 'max:255'],
//
//            // checkbox
//            'type_application' => ['required'],
//            // radio
//            'type_work' => ['required', Rule::in([TypeWork::$TYPE_WORK_1, TypeWork::$TYPE_WORK_2, TypeWork::$TYPE_WORK_3])],
//            // radio
//            'type_job' => ['required', Rule::in([TypeJob::$TYPE_JOB_1, TypeJob::$TYPE_JOB_2, TypeJob::$TYPE_JOB_3, TypeJob::$TYPE_JOB_4, TypeJob::$TYPE_JOB_5])],
//            // radio
//            'type_salary' => ['required', Rule::in([TypeSalary::$TYPE_SALARY_1, TypeSalary::$TYPE_SALARY_2, TypeSalary::$TYPE_SALARY_3, TypeSalary::$TYPE_SALARY_4])],
//            // radio + text ***
//            'type_study' => ['required', 'digits_between:1,13'],
//            // radio + text
//            'career' => ['required', 'numeric'],
//            // radio
//            'type_day' => ['required', Rule::in([TypeDay::$TYPE_DAY_1, TypeDay::$TYPE_DAY_2, TypeDay::$TYPE_DAY_3, TypeDay::$TYPE_DAY_4])],
//            // checkbox
            'type_benefit' => ['required'],
//
//            'started_at' => ['required', 'date_format:Y-m-d'],
//            'ended_at' => ['required', 'date_format:Y-m-d', 'after:started_at'],
//            'content' => ['nullable'],
        ]);

//        $recruit = Recruit::create([
//            'user_id' => auth()->id(),
//            'company_name' => $validatedData['company_name'],
//            'company_leader' => $validatedData['company_name'],
//            'company_license' => $validatedData['company_name'],
//            'company_phone' => $validatedData['company_name'],
//
//            'name' => $validatedData['name'],
//            'phone' => $validatedData['phone'],
//            'email' => $validatedData['email'],
//            'url' => $validatedData['url'],
//            'subway' => $validatedData['subway'],
//
//            'address' => "서울 송파구 오금동",
//            'address_detail' => "아남아파트",
//            'sido' => "서울",
//            'gugun' => '송파구',
//            'dong' => '오금동',
//            'latitude' => '37.50416961685561',
//            'longitude' => '127.02096038259408',
//
//            'type_work_id' => $validatedData['type_work'],
//            'type_job_id' => $validatedData['type_job'],
//            'type_study_id' => $validatedData['type_study'],
//            'career' => $validatedData['career'],
//
//            'started_at' => $validatedData['started_at'],
//            'ended_at' => $validatedData['ended_at'],
//            'content' => $validatedData['content'],
//        ]);

        // 복리후생 다중 선택값 넣기
        $benefit = RecruitBenefit::where('recruit_id', '=', 12)->first();
        if (!$benefit) {
            foreach($validatedData['type_benefit'] as $key => $value) {
                RecruitBenefit::create([
                    'type' => TypeBenefit::find($key)['type'],
                    'recruit_id' => 12,
                    'type_benefit_id' => $key,
                ]);
            }
        }

        ddd($request->request);

        return redirect()->route('albatalk.payment');
    }
}
