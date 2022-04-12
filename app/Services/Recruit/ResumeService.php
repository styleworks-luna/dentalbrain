<?php

namespace App\Services\Recruit;

use App\Models\Resume\Resume;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResumeService
{
    public function getResumeValidator(array $data)
    {
        $privacyRules = [
            'work_area' => ['nullable', 'string', 'max:100',],
            'work_day' => ['nullable', 'string', 'max:100',],
            'work_time' => ['nullable', 'string', 'max:100',],
            'name' => ['required', 'string', 'max:100',],
            'english_name' => ['required', 'string', 'max:100',],
            'birthday' => ['required', 'string', 'max:100',],
            'phone' => ['required', 'string', 'max:100',],
            'emergency_phone' => ['required', 'string', 'max:100',],
            'email' => ['required', 'email', 'max:100'],
            'address' => ['required', 'string', 'max:100',],
            'graduated_at' => ['nullable', 'string', 'max:100',],
            'school' => ['nullable', 'string', 'max:100',],
            'major' => ['nullable', 'string', 'max:100',],
            'degree' => ['nullable', 'string', 'max:100',],
            'graduation_type' => ['nullable', 'string', 'max:100',],
            'about_me' => ['nullable', 'string', 'max:1000'],
        ];

        $certificateRules = [
            'certificate_name_1' => ['nullable', 'string', 'max:100'],
            'certificate_day_1' => ['nullable', 'string', 'max:100'],
            'certificate_agency_1' => ['nullable', 'string', 'max:100'],
            'certificate_name_2' => ['nullable', 'string', 'max:100'],
            'certificate_day_2' => ['nullable', 'string', 'max:100'],
            'certificate_agency_2' => ['nullable', 'string', 'max:100'],
            'certificate_name_3' => ['nullable', 'string', 'max:100'],
            'certificate_day_3' => ['nullable', 'string', 'max:100'],
            'certificate_agency_3' => ['nullable', 'string', 'max:100'],
            'certificate_name_4' => ['nullable', 'string', 'max:100'],
            'certificate_day_4' => ['nullable', 'string', 'max:100'],
            'certificate_agency_4' => ['nullable', 'string', 'max:100'],
            'certificate_name_5' => ['nullable', 'string', 'max:100'],
            'certificate_day_5' => ['nullable', 'string', 'max:100'],
            'certificate_agency_5' => ['nullable', 'string', 'max:100'],
        ];

        $jobPositionRules = [
            'treatment_1' => ['nullable', 'string', 'max:100',],
            'treatment_2' => ['nullable', 'string', 'max:100',],
            'treatment_3' => ['nullable', 'string', 'max:100',],
            'department_1' => ['nullable', 'string', 'max:100',],
            'department_2' => ['nullable', 'string', 'max:100',],
            'department_3' => ['nullable', 'string', 'max:100',],
        ];

        return Validator::make($data, array_merge($privacyRules, $certificateRules, $jobPositionRules), [
            'required' => '필수로 작성하셔야 합니다.',
            'max' => ':max 자 이내로 입력해 주세요.'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getFileValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->file(),
            ['resume_image' => ['required', 'image', 'max:2048',]],
            ['resume_image.max' => '이력서 사진을 2MB 아래로 제출해 주세요',]);
    }

    /**
     * @return Builder|Model|object|null
     */
    public function getLoginUsersResume()
    {
        if (Auth::check() == false) {
            return null;
        }

        $userId = Auth::id();
        return Resume::query()->with(['file', 'user'])
            ->where('user_id', '=', $userId)
            ->orderBy('created_at', 'desc')->first();
    }

    public function existsResume(): bool
    {
        $userId = Auth::id();
        if (!Auth::check()) {
            return false;
        }
        return Resume::query()
            ->where('user_id', '=', $userId)
            ->exists();
    }
}
