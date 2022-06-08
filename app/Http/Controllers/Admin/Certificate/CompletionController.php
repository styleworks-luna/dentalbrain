<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionCategory;
use App\Models\Certificate\CertificateCompletion;
use App\Models\Certificate\QualificationCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompletionController extends Controller
{
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $this->validateCompletion($request);

        CertificateCompletion::query()->create($validated);

        return response()->json(['msg' => '생성되었습니다.']);
    }

    public function update(Request $request, CertificateCompletion $completion): \Illuminate\Http\JsonResponse
    {
        $validated = $this->validateCompletion($request);

        $completion->update($validated);

        return response()->json(['msg' => '수정되었습니다.']);
    }

    public function getDetail(Request $request, CertificateCompletion $completion): \Illuminate\Http\JsonResponse
    {
        return response()->json([$completion]);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function validateCompletion(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', Rule::in([CompletionCategory::COMPLETION_CATEGORY_01, CompletionCategory::COMPLETION_CATEGORY_02])],
            'title' => ['required', 'string', 'max:80',],
            'content' => ['required', 'max:80',],
            'bottom_content' => ['required', 'max:80',],
        ]);
    }

    public function getCompletionCategories(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'completionCategory' => CompletionCategory::query()->get()
        ]);
    }
}
