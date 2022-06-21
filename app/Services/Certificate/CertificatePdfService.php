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


    public function pdfCompletions(Program $program, $keyword)
    {
        $this->cleanUpTempPdfs();

        $C_profileCollection =
            $this->certificateRepository->whereForSearch(
                CompletionProfile::query()->from('completion_profiles as profiles')
                    ->select('profiles.*'), $program, 'ended', $keyword
            )
                ->where('status', '=', CompletionProfile::$PASS)->where('is_issued', '=', true)
                ->with('file')
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

    public function pdfQualifications(Program $program, $keyword)
    {
        $this->cleanUpTempPdfs();

        $Q_profileCollection =
            $this->certificateRepository->whereForSearch(
                QualificationProfile::query()->from('qualification_profiles as profiles')
                    ->select('profiles.*'), $program, 'ended', $keyword
            )
                ->where('status', '=', CompletionProfile::$PASS)->where('is_issued', '=', true)
                ->with('file')
                ->get();

        if ($Q_profileCollection->isEmpty()) {
            return null;
        }

        $qualification = $program->certificateQualification;
        $Q_categories = QualificationCategory::all();

        Pdf::setOptions(['isFontSubsettingEnabled' => true]);
        $folderName = Str::random();
        $pdfImages = new PdfImages();

        foreach ($Q_profileCollection as $Q_profile) {
            $categoryName = $Q_categories->find($qualification->category_id)->name;
            $pdf = new QualificationPdf($qualification, $Q_profile, $categoryName, $pdfImages);

            $filename = $pdf->getFileName();
            Storage::put("temp/pdfs/$folderName/$filename", $pdf->getPdf()->output());
        }
        for ($i = 0; $i <= 30; $i++) {
            foreach ($Q_profileCollection as $Q_profile) {
                $categoryName = $Q_categories->find($qualification->category_id)->name;
                $pdf = new QualificationPdf($qualification, $Q_profile, $categoryName, $pdfImages);

                $filename = Str::random(10) . ".pdf";
                Storage::put("temp/pdfs/$folderName/$filename", $pdf->getPdf()->output());
            }
        }


        return $this->makeZipWithFiles($folderName);
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
