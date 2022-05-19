<?php

namespace App\Services\Certificate;

use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Traits\HasCertificateStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

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
     * @return Paginator
     */
    public function searchProgramsCertificateProfiles(Program $program, ?string $keyword, $category): Paginator
    {
        $completionQuery = $this->selectForSearch(CompletionProfile::query()->from('completion_profiles as profiles'), '수료증');
        $completionQuery = $this->whereForSearch($completionQuery, $program, $category, $keyword);

        $qualificationQuery = $this->selectForSearch(QualificationProfile::query()->from('qualification_profiles as profiles'), '자격증');
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

        return new Paginator($result, $perPage, $page);
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
        $completionQuery = $this->selectForSearch(CompletionProfile::query()->from('completion_profiles as profiles'), '수료증');
        $completionQuery = $this->whereForSearch($completionQuery, $program, $category, $keyword);

        $qualificationQuery = $this->selectForSearch(QualificationProfile::query()->from('qualification_profiles as profiles'), '자격증');
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

    private function selectForSearch($query, $type)
    {
        return $query->select([
            DB::raw("'$type' as type"),
            'users.login_id', 'profiles.name', 'users.email', 'users.phone', 'profiles.birthday',
            'profiles.university', 'profiles.student_number', 'profiles.score',
            'profiles.status', 'profiles.is_issued',
            'profiles.user_id', 'profiles.id', 'profiles.created_at',
        ]);
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
}
