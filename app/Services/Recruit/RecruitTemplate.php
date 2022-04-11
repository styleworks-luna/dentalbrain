<?php

namespace App\Services\Recruit;

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

class RecruitTemplate
{
    public function validateRecruit(Request $request)
    {
        $data = $request->validate([
            'dental_name' => ['required', 'string', 'min:2', 'max:255'],
            'ceo_name' => ['required', 'string', 'max:255'],
            'num' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'digits_between:9,11'],

            'manager_name' => ['required', 'string', 'min:2', 'max:100'],
            'manager_phone' => ['required', 'numeric', 'digits_between:9,11'],
            'manager_email' => ['required', 'string', 'email', 'max:255'],
            'homepage' => ['required', 'url'],
            'subway' => ['nullable', 'string', 'max:255'],
//
            'address' => ['required', 'string',],
            'address_detail' => ['nullable', 'string',],

            'sido' => ['required', 'string',],
            'gugun' => ['required', 'string',],
            'dong' => ['required', 'string', 'nullable'],

            'latitude' => ['required', 'regex:/^[0-9]{2,3}\.[0-9]{1,7}$/'],
            'longitude' => ['required', 'regex:/^[0-9]{2,3}\.[0-9]{1,7}$/'],

            'application' => ['required'],
            'work' => ['required', Rule::in([TypeWork::$TYPE_WORK_1, TypeWork::$TYPE_WORK_2, TypeWork::$TYPE_WORK_3])],
            'job' => ['required', Rule::in([TypeJob::$TYPE_JOB_1, TypeJob::$TYPE_JOB_2, TypeJob::$TYPE_JOB_3, TypeJob::$TYPE_JOB_4, TypeJob::$TYPE_JOB_5])],
            'salary' => ['required', Rule::in([TypeSalary::$TYPE_SALARY_1, TypeSalary::$TYPE_SALARY_2, TypeSalary::$TYPE_SALARY_3, TypeSalary::$TYPE_SALARY_4])],
            'salary_value' => ['nullable', Rule::requiredIf($request->salary == TypeSalary::$TYPE_SALARY_4)],
            'is_study' => ['required', Rule::in(Recruit::$ACADEMIC, Recruit::$NO_ACADEMIC)],
            'study' => ['nullable', Rule::requiredIf($request->is_study == Recruit::$ACADEMIC), 'digits_between:1, 14'],

            'is_career' => ['required', Rule::in(Recruit::$JUNIOR, Recruit::$SENIOR)],
            'career' => ['nullable', Rule::requiredIf($request->is_career == Recruit::$SENIOR), 'digits_between:1, 30'],
            'day' => ['required', Rule::in([TypeDay::$TYPE_DAY_1, TypeDay::$TYPE_DAY_2, TypeDay::$TYPE_DAY_3, TypeDay::$TYPE_DAY_4])],
            'day_value' => ['nullable', Rule::requiredIf($request->day == TypeDay::$TYPE_DAY_4)],
            'benefit' => ['required'],

            'started_at_ymd' => ['required', 'date_format:Y-m-d'],
            'ended_at_ymd' => ['required', 'date_format:Y-m-d', 'after:started_at_ymd'],

            'started_at_hm' => ['required', 'date_format:H:i'],
            'ended_at_hm' => ['required', 'date_format:H:i'],
            'content' => ['nullable'],
        ]);

        return $data;
    }

    public function storeRecruit(array $data)
    {
        $recruit = Recruit::create([
            'user_id' => auth()->id(),
            'company_name' => $data['dental_name'],
            'company_leader' => $data['ceo_name'],
            'company_license' => $data['num'],
            'company_phone' => $data['phone'],

            'name' => $data['manager_name'],
            'phone' => $data['manager_phone'],
            'email' => $data['manager_email'],
            'url' => $data['homepage'],
            'subway' => $data['subway'],

            'address' => $data['address'],
            'address_detail' => $data['address_detail'],
            'sido' => $data['sido'],
            'gugun' => $data['gugun'],
            'dong' => $data['dong'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],

            'type_work_id' => $data['work'],
            'type_job_id' => $data['job'],
            'type_study_id' => $data['is_study'] == Recruit::$NO_ACADEMIC ? TypeStudy::$TYPE_STUDY_14 : $data['study'],
            'career' => $data['is_career'] == Recruit::$JUNIOR ? 0 : $data['career'],

            'started_at' => $data['started_at_ymd']." ".$data['started_at_hm'].":00",
            'ended_at' => $data['ended_at_ymd']." ".$data['ended_at_hm'].":00",
            'content' => $data['content'],
        ]);

        return $recruit;

    }

    public function storeRecruitApplication(Recruit $recruit, array $data)
    {
        // 신청분야 다중 선택값 넣기
        $application = RecruitApplication::where('recruit_id', '=', $recruit->id)->first();
        if (!$application) {
            foreach ($data['application'] as $key => $value) {
                RecruitApplication::create([
                    'type' => TypeApplication::find($key)['type'],
                    'recruit_id' => $recruit->id,
                    'type_application_id' => $key,
                ]);
            }
        }

        return $application;
    }

    public function storeRecruitSalary(Recruit $recruit, array $data)
    {
        // 급여
        $salary = RecruitSalary::where('recruit_id', '=', $recruit->id)->first();
        if (!$salary) {
            RecruitSalary::create([
                'type' => TypeSalary::find($data['salary'])['type'],
                'value' => $data['salary_value'] ?? null,
                'recruit_id' => $recruit->id,
                'type_salary_id' => $data['salary'],
            ]);
        }

        return $salary;
    }

    public function storeRecruitDay(Recruit $recruit, array $data)
    {
        // 근무요일
        $day = RecruitDay::where('recruit_id', '=', $recruit->id)->first();
        if (!$day) {
            RecruitDay::create([
                'type' => TypeDay::find($data['day'])['type'],
                'value' => $data['day_value']  ?? null,
                'recruit_id' => $recruit->id,
                'type_day_id' => $data['day'],
            ]);
        }

        return $day;
    }

    public function storeRecruitBenefit(Recruit $recruit, array $data)
    {
        // 복리후생 다중 선택값 넣기
        $benefit = RecruitBenefit::where('recruit_id', '=', $recruit->id)->first();
        if (!$benefit) {
            foreach ($data['benefit'] as $key => $value) {
                RecruitBenefit::create([
                    'type' => TypeBenefit::find($key)['type'],
                    'recruit_id' => $recruit->id,
                    'type_benefit_id' => $key,
                ]);
            }
        }

        return $benefit;
    }

}
