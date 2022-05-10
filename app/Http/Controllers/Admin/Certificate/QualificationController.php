<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificateQualification;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:80',],
            'certification_number' => ['required', 'numeric',],
            'grade' => ['required', 'string', 'max:80',],
            'content' => ['required', 'max:80'],
        ]);

        $qualification = CertificateQualification::query()->create($validated);

        return response()->json(['message' => '생성되었습니다.']);
    }

    public function getDetail(Request $request, CertificateQualification $qualification)
    {
        return response()->json([$qualification]);
    }
}
