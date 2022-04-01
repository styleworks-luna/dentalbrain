<?php

namespace App\Http\Controllers\Albatalk\Recruit;

use App\Http\Controllers\Controller;
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
        $recruit = $request->validate([
            'company_name' => ['required', 'string', 'min:2', 'max:255'],
            'company_leader' => ['required', 'string', 'max:255'],
            'company_license' => ['required', 'string', 'max:255'],
            'company_phone' => ['required', 'numeric', 'digits_between:9,11'],

            'name' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'numeric', 'digits_between:9,11'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'url' => ['required', 'url'],
            'subway' => ['nullable', 'string', 'max:255'],

            // checkbox
            'type_application' => ['required'],
            // radio
            'type_work' => ['required', Rule::in([TypeWork::$TYPE_WORK_1, TypeWork::$TYPE_WORK_2, TypeWork::$TYPE_WORK_3])],
            // radio
            'type_job' => ['required', Rule::in([TypeJob::$TYPE_JOB_1, TypeJob::$TYPE_JOB_2, TypeJob::$TYPE_JOB_3, TypeJob::$TYPE_JOB_4, TypeJob::$TYPE_JOB_5])],
            // radio
            'type_salary' => ['required', Rule::in([TypeSalary::$TYPE_SALARY_1, TypeSalary::$TYPE_SALARY_2, TypeSalary::$TYPE_SALARY_3, TypeSalary::$TYPE_SALARY_4])],
            // radio + text ***
            'type_study' => ['required', 'digits_between:1,13'],
            // radio + text
            'career' => ['required', 'numeric'],
            // radio
            'type_day' => ['required', Rule::in([TypeDay::$TYPE_DAY_1, TypeDay::$TYPE_DAY_2, TypeDay::$TYPE_DAY_3, TypeDay::$TYPE_DAY_4])],
            // checkbox
            'type_benefit' => ['required'],

            'started_at' => ['required', 'date_format:Y-m-d'],
            'ended_at' => ['required', 'date_format:Y-m-d', 'after:started_at'],
            'content' => ['nullable'],
        ]);

        Recruit::create([
            'user_id' => auth()->id(),
            'company_name' => $recruit['company_name'],
            'company_leader' => $recruit['company_name'],
            'company_license' => $recruit['company_name'],
            'company_phone' => $recruit['company_name'],

            'name' => $recruit['name'],
            'phone' => $recruit['phone'],
            'email' => $recruit['email'],
            'url' => $recruit['url'],
            'subway' => $recruit['subway'],

            'address' => "서울 송파구 오금동",
            'address_detail' => "아남아파트",
            'sido' => "서울",
            'gugun' => '송파구',
            'dong' => '오금동',
            'latitude' => '37.50416961685561',
            'longitude' => '127.02096038259408',

            'type_work_id' => $recruit['type_work'],
            'type_job_id' => $recruit['type_job'],
            'type_study_id' => $recruit['type_study'],
            'career' => $recruit['career'],

            'started_at' => $recruit['started_at'],
            'ended_at' => $recruit['ended_at'],
            'content' => $recruit['content'],
        ]);

        ddd($request->request);

        return redirect()->route('albatalk.payment');
    }
}
