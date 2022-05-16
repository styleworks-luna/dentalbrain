<?php

namespace App\Http\Controllers\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CertificationPdfController extends Controller
{
    public function pdfOfCompletion(Program $program, User $user): \Illuminate\Http\Response
    {
        if (Auth::id() != $user->id || Auth::user()->is_admin == false) {
            throw new ModelNotFoundException();
        }

        $certificateCompletion = $program->certificateCompletion;
        $profile = CompletionProfile::query()
            ->with('file')
            ->where('program_id', '=', $program->id)
            ->where('user_id', '=', $user->id)
            ->first();
        if ($profile == null) {
            throw new ModelNotFoundException();
        }

        return $this->exportCompletionPdf($certificateCompletion, $profile)
            ->stream($program->title . ' ' . $user->name . ' 수료증.pdf');
    }

    public function pdfOfQualification(Program $program, User $user): \Illuminate\Http\Response
    {
        if (Auth::id() != $user->id || Auth::user()->is_admin == false) {
            throw new ModelNotFoundException();
        }

        $certificateQualification = $program->certificateQualification;
        $profile = QualificationProfile::query()
            ->with('file')
            ->where('program_id', '=', $program->id)
            ->where('user_id', '=', $user->id)
            ->first();
        if ($profile == null) {
            throw new ModelNotFoundException();
        }
        return $this->exportQualificationPdf($certificateQualification, $profile)
            ->stream($program->title . ' ' . $user->name . ' 자격증.pdf');
    }

    private function exportQualificationPdf($certificateQualification, Model $profile): \Barryvdh\DomPDF\PDF
    {
        Pdf::setOptions(['isFontSubsettingEnabled' => true]);
        return Pdf::loadView('pdfs.qualification_pdf', [
            'certification' => $certificateQualification,
            'profile' => $profile
        ]);
    }

    private function exportCompletionPdf($certificateCompletion, Model $profile): \Barryvdh\DomPDF\PDF
    {
        Pdf::setOptions(['isFontSubsettingEnabled' => true]);
        return Pdf::loadView('pdfs.completion_pdf', [
            'certification' => $certificateCompletion,
            'profile' => $profile
        ]);
    }
}
