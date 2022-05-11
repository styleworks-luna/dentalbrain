<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificateQualification;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $this->validateQualification($request);

        CertificateQualification::query()->create($validated);

        return response()->json(['msg' => '생성되었습니다.']);
    }

    public function update(Request $request, CertificateQualification $qualification): \Illuminate\Http\JsonResponse
    {
        $validated = $this->validateQualification($request);


        $qualification->update($validated);

        return response()->json(['msg' => '수정되었습니다.']);
    }

    public function getDetail(Request $request, CertificateQualification $qualification): \Illuminate\Http\JsonResponse
    {
        return response()->json([$qualification]);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function validateQualification(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:80',],
            'certification_number' => ['required', 'numeric',],
            'grade' => ['required', 'string', 'max:80',],
            'content' => ['required', 'max:80'],
        ]);
    }
}
