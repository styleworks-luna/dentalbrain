<?php

namespace App\Http\Controllers\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Models\User;
use App\Services\Certificate\CertificatePdfService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CertificationPdfController extends Controller
{
    /**
     * @var CertificatePdfService
     */
    private $certificatePdfService;

    /**
     * @param CertificatePdfService $certificatePdfService
     */
    public function __construct(CertificatePdfService $certificatePdfService)
    {
        $this->certificatePdfService = $certificatePdfService;
    }


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

        return $this->certificatePdfService->exportCompletionPdf($certificateCompletion, $profile)
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

        return $this->certificatePdfService->exportQualificationPdf($certificateQualification, $profile)
            ->stream($program->title . ' ' . $user->name . ' 자격증.pdf');
    }


    /**
     * @param User $user
     */
    private function validateUser(User $user): void
    {
        if (Auth::id() != $user->id && Auth::user()->is_admin == false) {
            throw new ModelNotFoundException();
        }
    }

    /**
     * @param Model|CompletionProfile|QualificationProfile $profile
     */
    private function validateProfile($profile): void
    {
        if (Auth::user()->is_admin == true) {
            return;
        }
        if ($profile->status != QualificationProfile::$PASS || $profile->is_issued == false) {
            throw new ModelNotFoundException();
        }
    }
}
