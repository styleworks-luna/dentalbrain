<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificateCompletion;
use App\Models\Certificate\CertificateQualification;
use Illuminate\Http\Request;

class CompletionController extends Controller
{
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:80',],
            'content' => ['required', 'max:80',],
            'bottom_content' => ['required', 'max:80',],
        ]);

        $completion = CertificateCompletion::query()->create($validated);

        return response()->json(['message' => '생성되었습니다.']);
    }

    public function getDetail(Request $request, CertificateCompletion $completion)
    {
        return response()->json([$completion]);
    }
}
