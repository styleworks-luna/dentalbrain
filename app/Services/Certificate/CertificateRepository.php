<?php

namespace App\Services\Certificate;

use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Traits\HasCertificateStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CertificateRepository
{
    public function selectForCompletionSearch($query)
    {
        return $query->select(
            DB::raw("'수료증' as type"),
            'users.login_id', 'profiles.name', 'users.email', 'users.phone', 'profiles.birthday',
            'profiles.university', 'profiles.student_number', 'profiles.score',
            'profiles.status', 'profiles.is_issued',
            'profiles.user_id', 'profiles.id', 'profiles.created_at', DB::raw("null as certificate_number")
        );
    }

    public function selectForQualificationSearch($query)
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
    public function getCountAll(Program $program, $category, ?string $keyword): int
    {
        return $this->getCountOfQualifications($program, $category, $keyword) + $this->getCountOfCompletions($program, $category, $keyword);
    }

    /**
     * @param Program $program
     * @param $category
     * @param string|null $keyword
     * @return int
     */
    public function getCountOfQualifications(Program $program, $category, ?string $keyword): int
    {
        return $this->whereForSearch(QualificationProfile::query()->from('qualification_profiles as profiles'), $program, $category, $keyword)->count('profiles.id');
    }

    /**
     * @param Program $program
     * @param $category
     * @param string|null $keyword
     * @return int
     */
    public function getCountOfCompletions(Program $program, $category, ?string $keyword): int
    {
        return $this->whereForSearch(CompletionProfile::query()->from('completion_profiles as profiles'), $program, $category, $keyword)->count('profiles.id');
    }

    /**
     * @param Builder|\Illuminate\Database\Query\Builder $query
     * @param Program|Model $program
     * @param ?string $category
     * @param ?string $keyword
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function whereForSearch($query, $program, ?string $category, $keyword)
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
}
