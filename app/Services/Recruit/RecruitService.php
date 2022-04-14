<?php

namespace App\Services\Recruit;

use App\Http\Controllers\Albatalk\Recruit\RecruitSiDo;
use App\Models\File;
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
use App\Services\File\RecruitThumbnail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RecruitService
{
    public function getValidatorRecruit($rawData)
    {
        return Validator::make($rawData, [
            'main_file_id' => ['required', 'numeric', 'min:1',],
            'file_1_id' => ['nullable', 'numeric', 'min:1',],
            'file_2_id' => ['nullable', 'numeric', 'min:1',],
            'file_3_id' => ['nullable', 'numeric', 'min:1',],

            'dental_name' => ['required', 'string', 'min:2', 'max:255'],
            'ceo_name' => ['required', 'string', 'max:255'],
            'num' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'digits_between:9,11'],

            'manager_name' => ['required', 'string', 'min:2', 'max:100'],
            'manager_phone' => ['required', 'numeric', 'digits_between:9,11'],
            'manager_email' => ['required', 'string', 'email', 'max:255'],
            'homepage' => ['required', 'url'],
            'subway' => ['nullable', 'string', 'max:255'],

            'address' => ['required', 'string',],
            'address_detail' => ['nullable', 'string',],

            'sido' => ['required', 'string', Rule::in(RecruitSiDo::array())],
            'gugun' => ['nullable', 'string',],
            'dong' => ['required', 'string', 'nullable'],

            'latitude' => ['required', 'regex:/^[0-9]{2,3}\.[0-9]{1,7}$/'],
            'longitude' => ['required', 'regex:/^[0-9]{2,3}\.[0-9]{1,7}$/'],

            'application' => ['required'],
            'work' => ['required', Rule::in([TypeWork::$TYPE_WORK_1, TypeWork::$TYPE_WORK_2, TypeWork::$TYPE_WORK_3])],
            'job' => ['required', Rule::in([TypeJob::$TYPE_JOB_1, TypeJob::$TYPE_JOB_2, TypeJob::$TYPE_JOB_3, TypeJob::$TYPE_JOB_4, TypeJob::$TYPE_JOB_5])],
            'salary' => ['required', Rule::in([TypeSalary::$TYPE_SALARY_1, TypeSalary::$TYPE_SALARY_2, TypeSalary::$TYPE_SALARY_3, TypeSalary::$TYPE_SALARY_4])],
            'salary_value' => ['nullable', Rule::requiredIf(($rawData['salary'] ?? 0) == TypeSalary::$TYPE_SALARY_4)],
            'is_study' => ['required', Rule::in(Recruit::$ACADEMIC, Recruit::$NO_ACADEMIC)],
            'study' => ['nullable', Rule::requiredIf(($rawData['is_study'] ?? 0) == Recruit::$ACADEMIC), 'digits_between:1, 14'],

            'is_career' => ['required', Rule::in(Recruit::$JUNIOR, Recruit::$SENIOR)],
            'career' => ['nullable', Rule::requiredIf(($rawData['is_career'] ?? 0) == Recruit::$SENIOR), 'digits_between:1, 30'],
            'day' => ['required', Rule::in([TypeDay::$TYPE_DAY_1, TypeDay::$TYPE_DAY_2, TypeDay::$TYPE_DAY_3, TypeDay::$TYPE_DAY_4])],
            'day_value' => ['nullable', Rule::requiredIf(($rawData['day'] ?? 0) == TypeDay::$TYPE_DAY_4)],
            'benefit' => ['required'],

            'deadline' => ['required', Rule::in(Recruit::$DEADLINE_RECRUIT, Recruit::$TIME_FOR_RECRUIT)],
            'started_at_ymd' => ['nullable', Rule::requiredIf(($rawData['deadline'] ?? 0) == Recruit::$DEADLINE_RECRUIT), 'date_format:Y-m-d'],
            'ended_at_ymd' => ['nullable', Rule::requiredIf(($rawData['deadline'] ?? 0) == Recruit::$DEADLINE_RECRUIT), 'date_format:Y-m-d', 'after:started_at_ymd'],
            'started_at_hm' => ['nullable', Rule::requiredIf(($rawData['deadline'] ?? 0) == Recruit::$DEADLINE_RECRUIT), 'date_format:H:i'],
            'ended_at_hm' => ['nullable', Rule::requiredIf(($rawData['deadline'] ?? 0) == Recruit::$DEADLINE_RECRUIT), 'date_format:H:i'],

            'content' => ['nullable'],
        ]);
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

            'career' => $data['is_career'] == Recruit::$JUNIOR ? 0 : $data['career'],
            'type_work_id' => $data['work'],
            'type_job_id' => $data['job'],
            'type_study_id' => $data['is_study'] == Recruit::$NO_ACADEMIC ? TypeStudy::$TYPE_STUDY_14 : $data['study'],

            'started_at' => $data['deadline'] == Recruit::$TIME_FOR_RECRUIT ? null : $data['started_at_ymd'] . " " . $data['started_at_hm'] . ":00",
            'ended_at' => $data['deadline'] == Recruit::$TIME_FOR_RECRUIT ? null : $data['ended_at_ymd'] . " " . $data['ended_at_hm'] . ":00",
            'content' => $data['content'] ?? null,
        ]);

        return $recruit;

    }

    public function storeRecruitApplication(Recruit $recruit, array $data)
    {
        // 신청분야 다중 선택값 넣기
        $application = RecruitApplication::where('recruit_id', '=', $recruit->id)->first();
        if (!$application) {
            foreach ($data['application'] as $key => $value) {
                if ($value == 'on') {
                    RecruitApplication::create([
                        'type' => TypeApplication::find($key)['type'],
                        'recruit_id' => $recruit->id,
                        'type_application_id' => $key,
                    ]);
                }
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
                'value' => $data['day_value'] ?? null,
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
                if ($value == 'on') {
                    RecruitBenefit::create([
                        'type' => TypeBenefit::find($key)['type'],
                        'recruit_id' => $recruit->id,
                        'type_benefit_id' => $key,
                    ]);
                }
            }
        }

        return $benefit;
    }

    public function updateRecruit(Recruit $recruit, array $data)
    {
        $recruit->update([
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

            'career' => $data['is_career'] == Recruit::$JUNIOR ? 0 : $data['career'],
            'type_work_id' => $data['work'],
            'type_job_id' => $data['job'],
            'type_study_id' => $data['is_study'] == Recruit::$NO_ACADEMIC ? TypeStudy::$TYPE_STUDY_14 : $data['study'],

            'started_at' => $data['deadline'] == Recruit::$TIME_FOR_RECRUIT ? null : $data['started_at_ymd'] . " " . $data['started_at_hm'] . ":00",
            'ended_at' => $data['deadline'] == Recruit::$TIME_FOR_RECRUIT ? null : $data['ended_at_ymd'] . " " . $data['ended_at_hm'] . ":00",
            'content' => $data['content'] ?? null,
        ]);

        return $recruit;
    }


    public function validateFile(Request $request)
    {
        return $this->validateImage($request);
    }

    public function validateEditorFile(Request $request)
    {
        $validator = Validator::make($request->file(),
            ['file' => ['required', 'file', 'max:2048',]],
            ['file.max' => '이력서 사진을 2MB 아래로 제출해 주세요',]);
        $validator->validate();
        return $validator->validated()['file'];
    }

    public function validateEditorImage(Request $request)
    {
        return $this->validateImage($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function validateImage(Request $request)
    {
        $validator = Validator::make($request->file(),
            ['image' => ['required', 'image', 'max:2048',]],
            ['image.max' => '이력서 사진을 2MB 아래로 제출해 주세요',]);
        $validator->validate();
        return $validator->validated()['image'];
    }

    public function attachThumbnails(Recruit $recruit, array $validatedData)
    {
        $mainFile = File::query()->find($validatedData['main_file_id']);
        $file1 = File::query()->find($validatedData['file_1_id']);
        $file2 = File::query()->find($validatedData['file_2_id']);
        $file3 = File::query()->find($validatedData['file_3_id']);

        $recruitThumbnail = new RecruitThumbnail($recruit);
        $recruitThumbnail->moveTempFilesToPublic($mainFile, $file1, $file2, $file3);

        $recruit->main_file_id = $mainFile->id;
        $recruit->file_1_id = $file1 != null ? $file1->id : null;
        $recruit->file_2_id = $file2 != null ? $file2->id : null;
        $recruit->file_3_id = $file3 != null ? $file3->id : null;

        $recruit->save();
    }
}
