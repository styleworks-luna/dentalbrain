<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\DTO\Certification\CertificationDTO;
use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificateCompletion;
use App\Models\Certificate\CertificateQualification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CertificationController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            'keyword' => ['nullable', 'string'],
            'category' => ['nullable', 'string', Rule::in(['qualification', 'completion', 'all'])]
        ]);
        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? 'all';
        $collection = collect();

        if ($category == 'all' || $category == 'qualification') {
            if ($keyword == null) {
                $qualifications = CertificateQualification::all();
            } else {
                $qualifications = CertificateQualification::query()->where('title', 'LIKE', "%${keyword}%")->get();
            }
            $collection = $collection->concat($qualifications);
        }

        if ($category == 'all' || $category == 'completion') {
            if ($keyword == null) {
                $completions = CertificateCompletion::all();
            } else {
                $completions = CertificateCompletion::query()->where('title', 'LIKE', "%${keyword}%")->get();
            }
            $collection = $collection->concat($completions);
        }

        $num = 1;

        $result = $collection->sortByDesc('created_at')->map(function ($item) use (&$num) {
            if ($item instanceof CertificateCompletion) {
                return new CertificationDTO($num++, '수료증', $item);
            }
            if ($item instanceof CertificateQualification) {
                return new CertificationDTO($num++, '자격증', $item);
            }
            return new CertificationDTO($num++, '오류', $item);
        });

        return response()->json($result->toArray());
    }
}

