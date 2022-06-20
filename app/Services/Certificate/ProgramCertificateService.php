<?php

namespace App\Services\Certificate;

use App\Exports\Pdfs\CompletionPdf;
use App\Exports\Pdfs\QualificationPdf;
use App\Models\Certificate\CompletionCategory;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationCategory;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Traits\HasCertificateStatus;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ProgramCertificateService
{
    /**
     * @var CertificateService
     */
    private $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * @param Program $program
     * @param string|null $keyword
     * @param $category
     * @return AbstractPaginator
     */
    public function searchProgramsCertificateProfiles(Program $program, ?string $keyword, $category): AbstractPaginator
    {
        $completionQuery = $this->selectForCompletionSearch(CompletionProfile::query()->from('completion_profiles as profiles'));
        $completionQuery = $this->whereForSearch($completionQuery, $program, $category, $keyword);

        $qualificationQuery = $this->selectForQualificationSearch(QualificationProfile::query()->from('qualification_profiles as profiles'));
        $qualificationQuery = $this->whereForSearch($qualificationQuery, $program, $category, $keyword);

        $unionized = $completionQuery->union($qualificationQuery)->orderByDesc('created_at')->orderByDesc('type');

        $total = $this->getCount($program, $category, $keyword);
        $perPage = 10;
        $page = Paginator::resolveCurrentPage();
        $num = $total - (($page - 1) * $perPage);

        $result = $unionized
            ->offset($perPage * ($page - 1))
            ->limit($perPage)
            ->cursor();

        $result = $result->map(function ($item) use (&$num) {
            $item->num = $num--;
            return $item;
        });

        return new LengthAwarePaginator($result, $total, $perPage, $page);
    }

    /**
     * @param $status
     * @param Program $program
     * @param string|null $keyword
     * @param $category
     */
    public function updateProgramCertificateProfiles($status, Program $program, ?string $keyword, $category): void
    {
        $completionQuery = $this->whereForSearch(CompletionProfile::query()->from('completion_profiles as profiles'), $program, $category, $keyword);
        $completionIds = $completionQuery->pluck('profiles.id');
        if ($status == CompletionProfile::$PASS) {
            $this->certificateService->passCompletions($completionIds->values());
        } else {
            CompletionProfile::query()->whereIn('id', $completionIds)
                ->where('status', '!=', $status)
                ->update([
                    'status' => $status,
                    'passed_at' => null,
                ]);
        }

        $qualificationQuery = $this->whereForSearch(QualificationProfile::query()->from('qualification_profiles as profiles'), $program, $category, $keyword);
        $qualificationIds = $qualificationQuery->pluck('profiles.id');
        if ($status == QualificationProfile::$PASS) {
            $this->certificateService->passQualifications($qualificationIds->values());
        } else {
            QualificationProfile::query()->whereIn('id', $qualificationIds)
                ->where('status', '!=', $status)
                ->update([
                    'status' => $status,
                    'passed_at' => null,
                ]);
        }
    }

    /**
     * @param Program $program
     * @param $keyword
     * @param $category
     * @return Builder[]|Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function excelProgramCertificateProfiles(Program $program, $keyword, $category)
    {
        $completionQuery = $this->selectForCompletionSearch(CompletionProfile::query()->from('completion_profiles as profiles'));
        $completionQuery = $this->whereForSearch($completionQuery, $program, $category, $keyword);

        $qualificationQuery = $this->selectForQualificationSearch(QualificationProfile::query()->from('qualification_profiles as profiles'));
        $qualificationQuery = $this->whereForSearch($qualificationQuery, $program, $category, $keyword);
        $unionized = $completionQuery->union($qualificationQuery)->orderByDesc('created_at');

        return $unionized->get();
    }

    public function issueProgramCertificateProfiles(Program $program, $keyword, $category)
    {
        $completionQuery = $this->whereForSearch(CompletionProfile::query()->from('completion_profiles as profiles'), $program, $category, $keyword);
        $completionIds = $completionQuery->pluck('profiles.id');

        CompletionProfile::query()->whereIn('id', $completionIds)
            ->whereIn('status', [CompletionProfile::$PASS, CompletionProfile::$FAILED])
            ->update([
                'is_issued' => true,
            ]);

        $qualificationQuery = $this->whereForSearch(QualificationProfile::query()->from('qualification_profiles as profiles'), $program, $category, $keyword);
        $qualificationIds = $qualificationQuery->pluck('profiles.id');

        QualificationProfile::query()->whereIn('id', $qualificationIds)
            ->whereIn('status', [QualificationProfile::$PASS, CompletionProfile::$FAILED])
            ->update([
                'is_issued' => true,
            ]);
    }

    /**
     * @param $query
     * @param $program
     * @param $category
     * @param $keyword
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    private function whereForSearch($query, $program, $category, $keyword)
    {
        $query
            ->leftJoin('users', 'profiles.user_id', '=', 'users.id')
            ->where('profiles.program_id', '=', $program->id)
            ->where('profiles.status', '!=', HasCertificateStatus::$DO_NOT_PAID);

        if ($category != null) {
            if ($category == 'ongoing') {
                $query = $query->where('status', '=', HasCertificateStatus::$WAITING);
            } else if ($category == 'ended') {
                $query = $query->whereIn('status', [HasCertificateStatus::$FAILED, HasCertificateStatus::$PASS]);
            }
        }

        if ($keyword != null) {
            $query = $query->where(function (Builder $query) use ($keyword) {
                $query->where('profiles.name', 'LIKE', "%$keyword%")
                    ->orWhere('profiles.university', 'LIKE', "%$keyword%")
                    ->orWhere('users.email', 'LIKE', "%$keyword%")
                    ->orWhere('users.phone', 'LIKE', "%$keyword%");
            });
        }

        return $query;
    }

    private function selectForCompletionSearch($query)
    {
        return $query->select(
            DB::raw("'수료증' as type"),
            'users.login_id', 'profiles.name', 'users.email', 'users.phone', 'profiles.birthday',
            'profiles.university', 'profiles.student_number', 'profiles.score',
            'profiles.status', 'profiles.is_issued',
            'profiles.user_id', 'profiles.id', 'profiles.created_at', DB::raw("null as certificate_number")
        );
    }

    private function selectForQualificationSearch($query)
    {
        return $query->select(
            DB::raw("'자격증' as type"),
            'users.login_id', 'profiles.name', 'users.email', 'users.phone', 'profiles.birthday',
            'profiles.university', 'profiles.student_number', 'profiles.score',
            'profiles.status', 'profiles.is_issued',
            'profiles.user_id', 'profiles.id', 'profiles.created_at', 'profiles.certificate_number'
        );
    }

    /**
     * @param Program $program
     * @param $category
     * @param string|null $keyword
     * @return int
     */
    private function getCount(Program $program, $category, ?string $keyword): int
    {
        $qualificationCount = $this->whereForSearch(QualificationProfile::query()->from('qualification_profiles as profiles'), $program, $category, $keyword)->count('profiles.id');
        $completionCount = $this->whereForSearch(CompletionProfile::query()->from('completion_profiles as profiles'), $program, $category, $keyword)->count('profiles.id');

        return $qualificationCount + $completionCount;
    }

    public function pdfCompletions(Program $program, $keyword)
    {
        $this->cleanUpTempPdfs();

        $C_profileCollection =
            $this->whereForSearch(
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

        foreach ($C_profileCollection as $C_profile) {
            $categoryName = $C_categories->find($completion->category_id)->name;
            $pdf = new CompletionPdf($completion, $C_profile, $categoryName);
            $filename = $pdf->getFileName();
            Storage::put("temp/pdfs/$folderName/$filename", $pdf->getPdf()->output());
        }

        return $this->makeZipWithFiles($folderName);
    }

    public function pdfQualifications(Program $program, $keyword)
    {
        $this->cleanUpTempPdfs();

        $Q_profileCollection =
            $this->whereForSearch(
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

        foreach ($Q_profileCollection as $Q_profile) {
            $categoryName = $Q_categories->find($qualification->category_id)->name;
            $pdf = new QualificationPdf($qualification, $Q_profile, $categoryName);

            $filename = $pdf->getFileName();
            Storage::put("temp/pdfs/$folderName/$filename", $pdf->getPdf()->output());
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
