<?php

namespace App\Services\Certificate;

use App\Exports\Pdfs\CompletionPdf;
use App\Exports\Pdfs\PdfImages;
use App\Exports\Pdfs\QualificationPdf;
use App\Models\Certificate\CompletionCategory;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationCategory;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class CertificatePdfService
{
    private $certificateRepository;

    /**
     * @param CertificateRepository $certificateRepository
     */
    public function __construct(CertificateRepository $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }


    /**
     * 수료증 일괄 다운로드
     * @param Program $program
     * @param ?string $keyword
     * @param ?string $category
     * @param int $page
     * @return string|null
     */
    public function pdfAll(Program $program, ?string $keyword, ?string $category, int $page): ?string
    {
        $this->cleanUpTempPdfs();

        $completionQuery = $this->certificateRepository->selectForCompletionPdf(CompletionProfile::query()->from('completion_profiles as profiles'));
        $completionQuery = $this->certificateRepository->whereForSearch($completionQuery, $program, $category, $keyword
        )->with('file');

        $qualificationQuery = $this->certificateRepository->selectForQualificationPdf(QualificationProfile::query()->from('qualification_profiles as profiles'));
        $qualificationQuery = $this->certificateRepository->whereForSearch($qualificationQuery, $program, $category, $keyword
        )->with('file');

        $unionized = $completionQuery->union($qualificationQuery)->orderByDesc('created_at')->orderByDesc('type');

        $perPage = 10;

        $result = $unionized
            ->offset($perPage * ($page - 1))
            ->limit($perPage)
            ->cursor();

        $completion = $program->certificateCompletion;
        $qualification = $program->certificateQualification;

        Pdf::setOptions(['isFontSubsettingEnabled' => true]);
        $folderName = Str::random();
        $pdfImages = new PdfImages();

        if ($completion != null) {
            $C_categories = CompletionCategory::all();
            $C_categoryName = $C_categories->find($completion->category_id)->name;

            foreach ($result as $profile) {
                if ($profile->type == '수료증') {
                    $this->saveTempCompletion($completion, $profile, $C_categoryName, $pdfImages, $folderName);
                }
            }
        }

        if ($qualification != null) {
            $Q_categories = QualificationCategory::all();
            $Q_categoryName = $Q_categories->find($qualification->category_id)->name;

            foreach ($result as $profile) {
                if ($profile->type == '자격증') {
                    $this->saveTempQualification($qualification, $profile, $Q_categoryName, $pdfImages, $folderName);
                }
            }
        }

        return $this->makeZipWithFiles($folderName);
    }

    /**
     * 단일 자격증 생성
     * @param $certificateQualification
     * @param Model $profile
     * @return \Barryvdh\DomPDF\PDF
     */
    public function exportQualificationPdf($certificateQualification, Model $profile): \Barryvdh\DomPDF\PDF
    {
        $category = QualificationCategory::query()->findOrFail($certificateQualification->category_id);

        $pdfImages = new PdfImages();

        $qualificationPdf = new QualificationPdf($certificateQualification, $profile, $category->name, $pdfImages);

        return $qualificationPdf->getPdf();
    }

    /**
     * 단일 수료증 생성
     * @param $certificateCompletion
     * @param Model $profile
     * @return \Barryvdh\DomPDF\PDF
     */
    public function exportCompletionPdf($certificateCompletion, Model $profile): \Barryvdh\DomPDF\PDF
    {
        $category = CompletionCategory::query()->findOrFail($certificateCompletion->category_id);

        $pdfImages = new PdfImages();

        $completionPdf = new CompletionPdf($certificateCompletion, $profile, $category->name, $pdfImages);

        return $completionPdf->getPdf();
    }


    private function makeZipWithFiles(string $folderName): ?string
    {
        $filePaths = File::files(storage_path("app/temp/pdfs/$folderName"));

        $zip = new ZipArchive();
        $zipFilePath = storage_path("app/temp/pdfs/$folderName.zip");

        if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
            Log::error('Could not open ZIP file.');
            return null;
        }

        // Add File in ZipArchive
        foreach ($filePaths as $filePath) {
            if (!$zip->addFile($filePath, basename($filePath))) {
                Log::error('Could not add file to ZIP: ' . $filePath);
            }
        }
        // Close ZipArchive
        $zip->close();

        File::deleteDirectory(storage_path("app/temp/pdfs/$folderName"));
        Log::debug('Path:' . $zipFilePath);
        return $zipFilePath;
    }

    private function cleanUpTempPdfs()
    {
        try {
            $files = File::files(storage_path("app/temp/pdfs"));
            File::delete($files);
            $directories = File::directories(storage_path("app/temp/pdfs"));
            foreach ($directories as $directory) {
                @rmdir($directory);
            }
        } catch (\Exception $exception) {
        }
    }

    /**
     * @param $completion
     * @param $C_profile
     * @param $categoryName
     * @param PdfImages $pdfImages
     * @param string $folderName
     */
    private function saveTempCompletion($completion, $C_profile, $categoryName, PdfImages $pdfImages, string $folderName): void
    {
        $pdf = new CompletionPdf($completion, $C_profile, $categoryName, $pdfImages);
        $filename = $pdf->getFileName();
        Storage::put("temp/pdfs/$folderName/$filename", $pdf->getPdf()->output());
    }

    /**
     * @param $qualification
     * @param $Q_profile
     * @param $categoryName
     * @param PdfImages $pdfImages
     * @param string $folderName
     */
    private function saveTempQualification($qualification, $Q_profile, $categoryName, PdfImages $pdfImages, string $folderName): void
    {
        $pdf = new QualificationPdf($qualification, $Q_profile, $categoryName, $pdfImages);
        $filename = $pdf->getFileName();
        Storage::put("temp/pdfs/$folderName/$filename", $pdf->getPdf()->output());
    }
}
