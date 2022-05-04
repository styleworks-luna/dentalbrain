<?php

namespace App\Services\Recruit;

use App\DTO\Payment\CancelPaymentDto;
use App\Http\Controllers\Albatalk\Recruit\RecruitSiDo;
use App\Models\File;
use App\Models\Recruit\Option\RecruitApplication;
use App\Models\Recruit\Option\RecruitBenefit;
use App\Models\Recruit\Option\RecruitDay;
use App\Models\Recruit\Option\RecruitJob;
use App\Models\Recruit\Option\RecruitSalary;
use App\Models\Recruit\Option\TypeApplication;
use App\Models\Recruit\Option\TypeBenefit;
use App\Models\Recruit\Option\TypeCareer;
use App\Models\Recruit\Option\TypeDay;
use App\Models\Recruit\Option\TypeJob;
use App\Models\Recruit\Option\TypeSalary;
use App\Models\Recruit\Option\TypeStudy;
use App\Models\Recruit\Option\TypeWork;
use App\Models\Recruit\Recruit;
use App\Models\Resume\AppliedResume;
use App\Models\Resume\Resume;
use App\Services\File\RecruitThumbnail;
use App\Services\Payment\PaymentService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RecruitService
{
    public function getValidatorRecruit(Request $rawData, array $additionalRules = []): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($rawData->all(), array_merge([
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
            'homepage' => ['nullable', 'string', 'max:255'],
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
            'job' => ['required'],
            'salary' => ['required', Rule::in([TypeSalary::$TYPE_SALARY_1, TypeSalary::$TYPE_SALARY_2, TypeSalary::$TYPE_SALARY_3, TypeSalary::$TYPE_SALARY_4])],
            'salary_value' => ['nullable', Rule::requiredIf(($rawData['salary'] ?? 0) == TypeSalary::$TYPE_SALARY_4)],
            'is_study' => ['required', Rule::in(Recruit::$ACADEMIC, Recruit::$NO_ACADEMIC)],
            'study' => ['nullable', Rule::requiredIf(($rawData['is_study'] ?? 0) == Recruit::$ACADEMIC), 'digits_between:1, 14'],

            'is_career' => ['required', Rule::in(Recruit::JUNIOR, Recruit::SENIOR, Recruit::NO_CAREER)],
            'career' => ['nullable', Rule::requiredIf(($rawData['is_career'] == Recruit::SENIOR)), Rule::in(Recruit::SENIOR_SELECT_VALUE)],
            'day' => ['required', Rule::in([TypeDay::$TYPE_DAY_1, TypeDay::$TYPE_DAY_2, TypeDay::$TYPE_DAY_3, TypeDay::$TYPE_DAY_4])],
            'day_value' => ['nullable', Rule::requiredIf(($rawData['day'] ?? 0) == TypeDay::$TYPE_DAY_4)],
            'benefit' => ['required'],

            'content' => ['nullable'],
        ], $additionalRules));
    }

    public function storeRecruit(array $data)
    {
        return Recruit::create([
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

            'type_career_id' => $data['career'] ?? ( $data['is_career'] == Recruit::NO_CAREER ? TypeCareer::TYPE_CAREER_6 : TypeCareer::TYPE_CAREER_1),
            'type_work_id' => $data['work'],
            'type_study_id' => $data['is_study'] == Recruit::$NO_ACADEMIC ? TypeStudy::$TYPE_STUDY_14 : $data['study'],

            'expired_at' => now()->addDays($data['term']),

//            'started_at' => $data['deadline'] == Recruit::$TIME_FOR_RECRUIT ? null : $data['started_at_ymd'] . " " . $data['started_at_hm'] . ":00",
//            'ended_at' => $data['deadline'] == Recruit::$TIME_FOR_RECRUIT ? null : $data['ended_at_ymd'] . " " . $data['ended_at_hm'] . ":00",
            'content' => $data['content'] ?? null,
            'term' => $data['term'],
        ]);

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

    public function storeRecruitJob(Recruit $recruit, array $data)
    {
        // 복리후생 다중 선택값 넣기
        $job = RecruitJob::where('recruit_id', '=', $recruit->id)->first();
        if (!$job) {
            foreach ($data['job'] as $key => $value) {
                if ($value == 'on') {
                    RecruitJob::create([
                        'type' => TypeJob::find($key)['type'],
                        'recruit_id' => $recruit->id,
                        'type_job_id' => $key,
                    ]);
                }
            }
        }

        return $job;
    }

    public function updateRecruit(Recruit $recruit, array $data): Recruit
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

            'type_career_id' => $data['career'] ?? ( $data['is_career'] == Recruit::NO_CAREER ? TypeCareer::TYPE_CAREER_6 : TypeCareer::TYPE_CAREER_1),
            'type_work_id' => $data['work'],
            'type_study_id' => $data['is_study'] == Recruit::$NO_ACADEMIC ? TypeStudy::$TYPE_STUDY_14 : $data['study'],

//            'started_at' => $data['deadline'] == Recruit::$TIME_FOR_RECRUIT ? null : $data['started_at_ymd'] . " " . $data['started_at_hm'] . ":00",
//            'ended_at' => $data['deadline'] == Recruit::$TIME_FOR_RECRUIT ? null : $data['ended_at_ymd'] . " " . $data['ended_at_hm'] . ":00",
            'content' => $data['pay_status'] ?? null,
            'pay_status' => $data['pay_status'] ?? Recruit::$PAY_PAID,
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

        if ($mainFile != null && $mainFile->id != $recruit->main_file_id) {
            $this->deleteFile($recruit->main_file_id);
            $recruit->main_file_id = $mainFile->id;
            $recruitThumbnail->moveTempToPublic($mainFile);
        }
        if ($file1 != null && $file1->id != $recruit->file_1_id) {
            $this->deleteFile($recruit->file_1_id);
            $recruit->file_1_id = $file1->id;
            $recruitThumbnail->moveTempToPublic($file1);
        }
        if ($file2 != null && $file2->id != $recruit->file_2_id) {
            $this->deleteFile($recruit->file_2_id);
            $recruit->file_2_id = $file2->id;
            $recruitThumbnail->moveTempToPublic($file2);
        }
        if ($file3 != null && $file3->id != $recruit->file_3_id) {
            $this->deleteFile($recruit->file_3_id);
            $recruit->file_3_id = $file3->id;
            $recruitThumbnail->moveTempToPublic($file3);
        }
        $recruit->save();
    }

    private function deleteFile($fileId)
    {
        $file = File::query()->find($fileId);
        try {
            if ($file != null) {
                $path = $file->path;
                $file->delete();
                Storage::delete($path);
            }
        } catch (\Exception $ignored) {
        }
    }

    /**
     * @param null|Recruit $keyword
     * @param null|bool $ongoing
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchForAdmin($keyword, $ongoing)
    {
        $builder = Recruit::query()->with('user:id,login_id,name,email')
            ->select('id', 'is_open', 'user_id', 'company_name', 'created_at', 'expired_at')
            ->withCount(['appliedResumes' => function ($query) {
                $query->where('status', AppliedResume::STATUS_SUCCESS);
            }]);

        if ($keyword != null) {
            $builder->where(function ($query) use ($keyword) {
                $queryKey = "%${keyword}%";
                $query->orWhere('company_name', 'LIKE', $queryKey)
                    ->orWhereHas('user', function (Builder $query) use ($queryKey) {
                        $query->where('login_id', 'LIKE', $queryKey)
                            ->orWhere('name', 'LIKE', $queryKey)
                            ->orWhere('phone', 'LIKE', $queryKey);
                    });
            });
        }

        if ($ongoing != null) {
            if ($ongoing) {
                $builder->where('expired_at', '>=', now());
            } else {
                $builder->where('expired_at', '<', now());
            }
        }

        return $builder->orderByDesc('created_at')
            ->paginate(10);
    }

    public function validateAdminCancel(Request $request, Recruit $recruit): ?CancelPaymentDto
    {
        return CancelPaymentDto::createWhenRecruitCancelAdmin($request, $recruit);
    }

    public function cancel(Recruit $recruit, CancelPaymentDto $dto): bool
    {
        try {
            DB::beginTransaction();

            if ($recruit->payment != null) {
                PaymentService::cancelPaid($recruit->payment, $recruit->pay_status, $dto);
            }
            $recruit->updateWhenRecruitCancel();

            DB::commit();
            return true;

        } catch (\Exception $exception) {
            Log::error('CANCEL ERROR', [$exception]);
            DB::rollBack();
            return false;
        }
    }
}
