<?php

namespace App\Http\Controllers\Certificate;

use App\Exports\Pdfs\CompletionPdf;
use App\Exports\Pdfs\QualificationPdf;
use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionCategory;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationCategory;
use App\Models\Certificate\QualificationProfile;
use App\Models\File;
use App\Models\Program\Program;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
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
        $category = QualificationCategory::query()->findOrFail($certificateQualification->category_id);

        $qualificationPdf = new QualificationPdf($certificateQualification, $profile, $category->name);

        return $qualificationPdf->getPdf();
    }

    private function exportCompletionPdf($certificateCompletion, Model $profile): \Barryvdh\DomPDF\PDF
    {
        $category = CompletionCategory::query()->findOrFail($certificateCompletion->category_id);

        $completionPdf = new CompletionPdf($certificateCompletion, $profile, $category->name);

        return $completionPdf->getPdf();
    }

    private function defaultCertificationPdfImages(): Collection
    {
        return collect([
            'certification_back' => $this->encodeToBase64DefaultImg('/images/admin/certification_back.png'),
            'KDMA_mark' => $this->encodeToBase64DefaultImg('/images/admin/KDMA_mark.svg'),
            'KDMA_light_mark' => $this->encodeToBase64DefaultImg('/images/admin/KDMA_light_mark.svg'),
            'sign' => $this->encodeToBase64DefaultImg('/images/admin/sign.png'),
        ]);
    }

    private function encodeToBase64DefaultImg($imgPath): string
    {
        $path = public_path($imgPath);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    private function encodeToBase64(File $file): string
    {
        $path = storage_path('app/' . $file->path);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
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
