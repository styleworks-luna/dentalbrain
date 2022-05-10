<?php

namespace App\Services\Certificate;


use App\Models\Certificate\CertificateProfile;
use App\Models\Program\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CertificateService
{
    public function getValidatorRecruit(Request $rawData, array $additionalRules = []): array
    {
        $validated = Validator::make($rawData->all(), array_merge([
            'file' => ['required'],
            'name' => ['required', 'string', 'max:50'],
            'university' => ['nullable', 'string', 'max:50'],
            'student_number' => ['nullable', 'string', 'max:20'],
            'birthday' => ['required', 'string', 'max:20'],
        ], $additionalRules));

        return $validated->validate();
    }

    public function storeCertificateProfile(array $data, Program $program, $file)
    {
        return CertificateProfile::create([
            'user_id' => Auth::id(),
            'program_id' => $program->id,
            'qualification_id' => $program->qualification_id ?? null,
            'completion_id' => $program->completion_id ?? null,
            'file_id' => $file->id,
            'name' => $data['name'],
            'university' => $data['university'],
            'student_number' => $data['student_number'],
            'birthday' => $data['birthday'],
            'state' => CertificateProfile::DO_NOT_PAID,
        ], []);
    }
}
