<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificateQualification;
use App\Models\Certificate\CompletionCategory;
use App\Models\Certificate\QualificationCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QualificationController extends Controller
{
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $this->validateCreate($request);

        CertificateQualification::query()->create($validated);

        return response()->json(['msg' => '생성되었습니다.']);
    }

    public function update(Request $request, CertificateQualification $qualification): \Illuminate\Http\JsonResponse
    {
        $validated = $this->validateUpdate($request);


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
    private function validateCreate(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', Rule::exists("qualification_categories", "id")],
            'title' => ['required', 'string', 'max:80',],
            'certification_number' => ['required', 'numeric',],
            'grade' => ['required', 'string', 'max:80',],
            'content' => ['required', 'max:80'],
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function validateUpdate(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', Rule::exists("qualification_categories", "id")],
            'title' => ['required', 'string', 'max:80',],
            'grade' => ['required', 'string', 'max:80',],
            'content' => ['required', 'max:80'],
        ]);
    }

    public function getQualificationCategories(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'qualificationCategory' => QualificationCategory::query()->get()
        ]);
    }
}
