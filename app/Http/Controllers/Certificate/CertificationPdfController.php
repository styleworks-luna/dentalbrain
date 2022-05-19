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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CertificationPdfController extends Controller
{
    public function pdfOfCompletion(Program $program, User $user): Response
    {
        $this->validateUser($user);

        $certificateCompletion = $program->certificateCompletion;
        $profile = CompletionProfile::query()
            ->with('file')
            ->where('program_id', '=', $program->id)
            ->where('user_id', '=', $user->id)
            ->firstOrFail();

        $this->validateProfile($profile);

        return $this->exportCompletionPdf($certificateCompletion, $profile)
            ->stream($program->title . ' ' . $user->name . ' 수료증.pdf');
    }

    public function pdfOfQualification(Program $program, User $user): Response
    {
        $this->validateUser($user);

        $certificateQualification = $program->certificateQualification;
        $profile = QualificationProfile::query()
            ->with('file')
            ->where('program_id', '=', $program->id)
            ->where('user_id', '=', $user->id)
            ->firstOrFail();

        $this->validateProfile($profile);

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

    /**
     * @param User $user
     */
    public function validateUser(User $user): void
    {
        if (Auth::id() != $user->id && Auth::user()->is_admin == false) {
            throw new ModelNotFoundException();
        }
    }

    /**
     * @param Model|CompletionProfile|QualificationProfile $profile
     */
    public function validateProfile($profile): void
    {
        if (Auth::user()->is_admin == true) {
            return;
        }
        if ($profile->status != QualificationProfile::$PASS || $profile->is_issued == false) {
            throw new ModelNotFoundException();
        }
    }
}
