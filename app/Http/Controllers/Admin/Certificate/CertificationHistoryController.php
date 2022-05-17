<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Traits\HasCertificateStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CertificationHistoryController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            'keyword' => ['nullable', 'string',],
            'category' => ['nullable', Rule::in(['completion', 'qualification']),],
        ]);

        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;

        $keyword = $keyword == null ? null : "%${keyword}%";

        $completionQuery = $this->getCompletionQuery($keyword);
        $qualificationQuery = $this->getQualificationQuery($keyword);

        if ($category == 'completion') {
            $query = $completionQuery;
            $total = $this->getCompletionCount($keyword);
        } elseif ($category == 'qualification') {
            $query = $qualificationQuery;
            $total = $this->getQualificationCount($keyword);
        } else {
            $query = $qualificationQuery->union($completionQuery);
            $total = $this->getCompletionCount($keyword) + $this->getQualificationCount($keyword);
        }

        $result = $query->orderByDesc('created_at')->get()
            ->transform(function ($item, $index) use ($total) {
                $item->num = $total - $index;
                return $item;
            })->paginate(10, $total);

        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * @param string|null $keyword
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    private function getQualificationQuery(?string $keyword)
    {
        $builder = QualificationProfile::query()
            ->select([
                'qualification_profiles.id as id',
                DB::raw("'자격증' as type"),
                'certificate_qualifications.title as title',
                'programs.title as program_title',
                'users.login_id as login_id',
                'qualification_profiles.name as name',
                'users.email as email',
                'users.phone as phone',
                'qualification_profiles.created_at'
            ])
            ->from('qualification_profiles')
            ->leftJoin('programs', 'programs.id', '=', 'qualification_profiles.program_id')
            ->leftJoin('certificate_qualifications', 'certificate_qualifications.id', '=', 'programs.qualification_id')
            ->leftJoin('users', 'qualification_profiles.user_id', '=', 'users.id')
            ->whereIn('qualification_profiles.status', [HasCertificateStatus::$WAITING, HasCertificateStatus::$FAILED, HasCertificateStatus::$PASS,]);

        if ($keyword != null) {
            return $builder->where(function (Builder $query) use ($keyword) {
                $query->where('certificate_qualifications.title', 'LIKE', $keyword)
                    ->orWhere('programs.title', 'LIKE', $keyword)
                    ->orWhere('users.login_id', 'LIKE', $keyword)
                    ->orWhere('qualification_profiles.name', 'LIKE', $keyword);
            });
        }
        return $builder;

    }

    /**
     * @param string|null $keyword
     * @return int
     */
    private function getQualificationCount(?string $keyword): int
    {
        $builder = QualificationProfile::query()
            ->from('qualification_profiles')
            ->leftJoin('programs', 'programs.id', '=', 'qualification_profiles.program_id')
            ->leftJoin('certificate_qualifications', 'certificate_qualifications.id', '=', 'programs.qualification_id')
            ->leftJoin('users', 'qualification_profiles.user_id', '=', 'users.id')
            ->whereIn('qualification_profiles.status', [HasCertificateStatus::$WAITING, HasCertificateStatus::$FAILED, HasCertificateStatus::$PASS,]);

        if ($keyword != null) {
            return $builder->where(function (Builder $query) use ($keyword) {
                $query->where('certificate_qualifications.title', 'LIKE', $keyword)
                    ->orWhere('programs.title', 'LIKE', $keyword)
                    ->orWhere('users.login_id', 'LIKE', $keyword)
                    ->orWhere('qualification_profiles.name', 'LIKE', $keyword);
            })->count('qualification_profiles.id');
        }
        return $builder->count('qualification_profiles.id');
    }

    /**
     * @param string|null $keyword
     * @return int
     */
    private function getCompletionCount(?string $keyword): int
    {
        $builder = CompletionProfile::query()
            ->from('completion_profiles')
            ->leftJoin('programs', 'programs.id', '=', 'completion_profiles.program_id')
            ->leftJoin('certificate_completions', 'certificate_completions.id', '=', 'programs.completion_id')
            ->leftJoin('users', 'completion_profiles.user_id', '=', 'users.id')
            ->whereIn('completion_profiles.status', [HasCertificateStatus::$WAITING, HasCertificateStatus::$FAILED, HasCertificateStatus::$PASS,]);

        if ($keyword != null) {
            return $builder->where(function (Builder $query) use ($keyword) {
                $query->where('certificate_completions.title', 'LIKE', $keyword)
                    ->orWhere('programs.title', 'LIKE', $keyword)
                    ->orWhere('users.login_id', 'LIKE', $keyword)
                    ->orWhere('completion_profiles.name', 'LIKE', $keyword);
            })->count('completion_profiles.id');
        }
        return $builder->count('completion_profiles.id');
    }

    /**
     * @param string|null $keyword
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function getCompletionQuery(?string $keyword)
    {
        $builder = CompletionProfile::query()
            ->select(['completion_profiles.id as id',
                DB::raw("'수료증' as type"),
                'certificate_completions.title as title',
                'programs.title as program_title',
                'users.login_id as login_id',
                'completion_profiles.name as name',
                'users.email as email',
                'users.phone as phone',
                'completion_profiles.created_at',
            ])
            ->from('completion_profiles')
            ->leftJoin('programs', 'programs.id', '=', 'completion_profiles.program_id')
            ->leftJoin('certificate_completions', 'certificate_completions.id', '=', 'programs.completion_id')
            ->leftJoin('users', 'completion_profiles.user_id', '=', 'users.id')
            ->whereIn('completion_profiles.status', [HasCertificateStatus::$WAITING, HasCertificateStatus::$FAILED, HasCertificateStatus::$PASS,]);

        if ($keyword != null) {
            return $builder
                ->where(function (Builder $query) use ($keyword) {
                    $query->where('certificate_completions.title', 'LIKE', $keyword)
                        ->orWhere('programs.title', 'LIKE', $keyword)
                        ->orWhere('users.login_id', 'LIKE', $keyword)
                        ->orWhere('completion_profiles.name', 'LIKE', $keyword);
                });
        }
        return $builder;
    }
}

