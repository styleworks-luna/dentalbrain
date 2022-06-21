<?php

namespace App\Services\Certificate;

use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ProgramCertificateService
{
    /**
     * @var CertificateService
     */
    private $certificateService;
    private $certificateRepository;

    public function __construct(CertificateService $certificateService, CertificateRepository $certificateRepository)
    {
        $this->certificateService = $certificateService;
        $this->certificateRepository = $certificateRepository;
    }

    /**
     * @param Program $program
     * @param string|null $keyword
     * @param $category
     * @return AbstractPaginator
     */
    public function searchProgramsCertificateProfiles(Program $program, ?string $keyword, $category): AbstractPaginator
    {
        $completionQuery = $this->certificateRepository->selectForCompletionSearch(CompletionProfile::query()->from('completion_profiles as profiles'));
        $completionQuery = $this->certificateRepository->whereForSearch($completionQuery, $program, $category, $keyword);

        $qualificationQuery = $this->certificateRepository->selectForQualificationSearch(QualificationProfile::query()->from('qualification_profiles as profiles'));
        $qualificationQuery = $this->certificateRepository->whereForSearch($qualificationQuery, $program, $category, $keyword);

        $unionized = $completionQuery->union($qualificationQuery)->orderByDesc('created_at')->orderByDesc('type');

        $total = $this->certificateRepository->getCount($program, $category, $keyword);
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
        $completionQuery = $this->certificateRepository->whereForSearch(CompletionProfile::query()->from('completion_profiles as profiles'), $program, $category, $keyword);
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

        $qualificationQuery = $this->certificateRepository->whereForSearch(QualificationProfile::query()->from('qualification_profiles as profiles'), $program, $category, $keyword);
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
        $completionQuery = $this->certificateRepository->selectForCompletionSearch(CompletionProfile::query()->from('completion_profiles as profiles'));
        $completionQuery = $this->certificateRepository->whereForSearch($completionQuery, $program, $category, $keyword);

        $qualificationQuery = $this->certificateRepository->selectForQualificationSearch(QualificationProfile::query()->from('qualification_profiles as profiles'));
        $qualificationQuery = $this->certificateRepository->whereForSearch($qualificationQuery, $program, $category, $keyword);
        $unionized = $completionQuery->union($qualificationQuery)->orderByDesc('created_at');

        return $unionized->get();
    }

    public function issueProgramCertificateProfiles(Program $program, $keyword, $category)
    {
        $completionQuery = $this->certificateRepository->whereForSearch(CompletionProfile::query()->from('completion_profiles as profiles'), $program, $category, $keyword);
        $completionIds = $completionQuery->pluck('profiles.id');

        CompletionProfile::query()->whereIn('id', $completionIds)
            ->whereIn('status', [CompletionProfile::$PASS, CompletionProfile::$FAILED])
            ->update([
                'is_issued' => true,
            ]);

        $qualificationQuery = $this->certificateRepository->whereForSearch(QualificationProfile::query()->from('qualification_profiles as profiles'), $program, $category, $keyword);
        $qualificationIds = $qualificationQuery->pluck('profiles.id');

        QualificationProfile::query()->whereIn('id', $qualificationIds)
            ->whereIn('status', [QualificationProfile::$PASS, CompletionProfile::$FAILED])
            ->update([
                'is_issued' => true,
            ]);
    }

}
