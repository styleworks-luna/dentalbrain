<?php

namespace App\Services\Recruit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResumeService
{
    public function getResumeValidator(array $data)
    {
        return Validator::make($data, [
            'work_area' => ['nullable', 'string',],
            'work_day' => ['nullable', 'string',],
            'work_time' => ['nullable', 'string',],
            'name' => ['required', 'string',],
            'english_name' => ['required', 'string',],
            'birthday' => ['required', 'string',],
            'phone' => ['required', 'string',],
            'emergency_phone' => ['required', 'string',],
            'email' => ['required', 'email',],
            'address' => ['required', 'string',],
            'graduated_at' => ['nullable', 'string',],
            'school' => ['nullable', 'string',],
            'major' => ['nullable', 'string',],
            'degree' => ['nullable', 'string',],
            'graduation_type' => ['nullable', 'string',],
            'about_me' => ['nullable', 'string',],
        ], [
            'required' => '필수로 작성하셔야 합니다.',

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
}
