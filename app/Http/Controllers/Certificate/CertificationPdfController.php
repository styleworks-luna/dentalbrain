<?php

namespace App\Http\Controllers\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CertificationPdfController extends Controller
{
    public function pdfOfCompletion(Program $program, User $user): \Illuminate\Http\Response
    {
        $certificateCompletion = $program->certificateCompletion;
        $profile = CompletionProfile::query()
            ->with('file')
            ->where('program_id', '=', $program->id)
            ->where('user_id', '=', $user->id)
            ->first();
        if ($profile == null) {
            throw new ModelNotFoundException();
        }

        return $this->exportCompletionPdf($certificateCompletion, $profile)->stream();
    }

    public function pdfOfQualification(Program $program, User $user): \Illuminate\Http\Response
    {
        $certificateQualification = $program->certificateQualification;
        $profile = QualificationProfile::query()
            ->with('file')
            ->where('program_id', '=', $program->id)
            ->where('user_id', '=', $user->id)
            ->first();
        if ($profile == null) {
            throw new ModelNotFoundException();
        }
        return $this->exportQualificationPdf($certificateQualification, $profile)->stream();
    }

    private function exportQualificationPdf($certificateQualification, Model $profile): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('pdfs.qualification_pdf', [
            'certification' => $certificateQualification,
            'profile' => $profile
        ]);
    }

    private function exportCompletionPdf($certificateCompletion, Model $profile): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('pdfs.completion_pdf', [
            'certification' => $certificateCompletion,
            'profile' => $profile
        ]);
    }
}
