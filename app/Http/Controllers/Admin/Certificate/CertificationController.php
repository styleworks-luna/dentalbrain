<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\DTO\Certification\CertificationDTO;
use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificateCompletion;
use App\Models\Certificate\CertificateQualification;

class CertificationController extends Controller
{
    public function search()
    {
        $num = 1;
        $qualifications = CertificateQualification::all();
        $completions = CertificateCompletion::all();
        $collection = $qualifications->concat($completions);

        $result = $collection->sortByDesc('created_at')->map(function ($item) use (&$num) {
            return new CertificationDTO($num++, '수료증', $item);
        });

        return response()->json($result->toArray());
    }
}

