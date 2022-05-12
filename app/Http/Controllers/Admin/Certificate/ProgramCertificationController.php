<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Traits\HasCertificateStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramCertificationController extends Controller
{
    public function index(Request $request, Program $program): JsonResponse
    {
        $validated = $request->validate([
            'category' => ['nullable', 'numeric'],
            'keyword' => ['nullable', 'string']
        ]);

        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;

        $result = $this->searchProgramsCertificateProfiles($program, $keyword, $category);

        return response()->json($result->paginate(10));
    }

    /**
     * @param Program $program
     * @param string|null $keyword
     * @param $category
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function searchProgramsCertificateProfiles(Program $program, ?string $keyword, $category)
    {
        $completionQuery = $this->searchQuery(CompletionProfile::query()->from('completion_profiles as profiles'), $program, $category, $keyword);
        $qualificationQuery = $this->searchQuery(QualificationProfile::query()->from('qualification_profiles as profiles'), $program, $category, $keyword);
        return $completionQuery->union($qualificationQuery)->orderByDesc('created_at');
    }

    public function searchQuery($query, $program, $category, $keyword)
    {
        $query->select([
            'profiles.id', 'profiles.status', 'profiles.created_at',
            'users.login_id', 'profiles.name', 'users.email', 'users.phone', 'profiles.birthday', 'profiles.university', 'profiles.student_number',
        ])
            ->leftJoin('users', 'profiles.user_id', '=', 'users.id')
            ->where('profiles.program_id', '=', $program->id)
            ->where('profiles.status', '!=', HasCertificateStatus::$DO_NOT_PAID);

        if ($category != null) {
            $this->searchProfilesByCategory($query, $category);
        }

        if ($keyword != null) {
            $query->where(function (Builder $query) use ($keyword) {
                $query->where('profiles.name', 'LIKE', "%$keyword%")
                    ->orWhere('profiles.university', 'LIKE', "%$keyword%")
                    ->orWhere('users.email', 'LIKE', "%$keyword%")
                    ->orWhere('users.phone', 'LIKE', "%$keyword%");
            });
        }

        return $query;
    }

    /**
     * @param Builder|\Illuminate\Database\Query\Builder $query
     * @param $category
     */
    private function searchProfilesByCategory(Builder $query, $category): void
    {
        if ($category == 'ongoing') {
            $query->where('status', '=', HasCertificateStatus::$WAITING);
            return;
        }
        if ($category == 'ended') {
            $query->whereIn('status', [HasCertificateStatus::$FAILED, HasCertificateStatus::$PASS]);
        }
    }

}
