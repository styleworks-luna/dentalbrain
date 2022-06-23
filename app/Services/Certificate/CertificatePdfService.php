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
    public function pdfCompletions(Program $program, ?string $keyword, ?string $category, int $page): ?string
    {
        $this->cleanUpTempPdfs();

        $perPage = 10;


        $C_profileCollection =
            $this->certificateRepository->whereForSearch(
                CompletionProfile::query()->from('completion_profiles as profiles')
                    ->select('profiles.*'), $program, $category, $keyword
            )
                ->where('status', '=', CompletionProfile::$PASS)->where('is_issued', '=', true)
                ->with('file')
                ->offset($perPage * ($page - 1))
                ->limit($perPage)
                ->get();

        if ($C_profileCollection->isEmpty()) {
            return null;
        }

        $completion = $program->certificateCompletion;
        $C_categories = CompletionCategory::all();

        Pdf::setOptions(['isFontSubsettingEnabled' => true]);
        $folderName = Str::random();
        $pdfImages = new PdfImages();

        foreach ($C_profileCollection as $C_profile) {
            $categoryName = $C_categories->find($completion->category_id)->name;
            $pdf = new CompletionPdf($completion, $C_profile, $categoryName, $pdfImages);
            $filename = $pdf->getFileName();
            Storage::put("temp/pdfs/$folderName/$filename", $pdf->getPdf()->output());
        }

        return $this->makeZipWithFiles($folderName);
    }

    /**
     *  자격증 일괄 다운로드
     * @param Program $program
     * @param ?string $keyword
     * @param ?string $category
     * @param int $page
     * @return string|null returns null if empty
     */
    public function pdfQualifications(Program $program, ?string $keyword, ?string $category, int $page): ?string
    {
        $this->cleanUpTempPdfs();

        $perPage = 10;

        $Q_profileCollection =
            $this->certificateRepository->whereForSearch(
                QualificationProfile::query()->from('qualification_profiles as profiles')
                    ->select('profiles.*'), $program, $category, $keyword
            )
                ->where('status', '=', CompletionProfile::$PASS)->where('is_issued', '=', true)
                ->with('file')
                ->offset($perPage * ($page - 1))
                ->limit($perPage)
                ->get();

        if ($Q_profileCollection->isEmpty()) {
            return null;
        }

        $qualification = $program->certificateQualification;
        $Q_categories = QualificationCategory::all(['id', 'name']);

        Pdf::setOptions(['isFontSubsettingEnabled' => true]);
        $folderName = Str::random();
        $pdfImages = new PdfImages();

        foreach ($Q_profileCollection as $Q_profile) {
            $categoryName = $Q_categories->find($qualification->category_id)->name;
            $pdf = new QualificationPdf($qualification, $Q_profile, $categoryName, $pdfImages);

            $filename = $pdf->getFileName();
            Storage::put("temp/pdfs/$folderName/$filename", $pdf->getPdf()->output());
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
}
