<?php

namespace App\Services\Recruit;

use Illuminate\Support\Facades\Validator;

class ResumeService
{
    public function getValidator(array $data)
    {
        return Validator::make($data, [
//          'file_id' => ['required', 'numeric'],
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
        ]);
    }
}
