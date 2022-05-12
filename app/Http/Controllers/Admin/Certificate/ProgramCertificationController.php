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
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

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

        $perPage = 10;
        $page = Paginator::resolveCurrentPage();
        $offset = $perPage * ($page - 1);

        $result = $this->searchProgramsCertificateProfiles($program, $keyword, $category)
            ->offset($offset)
            ->limit($perPage)
            ->get();

        $paginator = new Paginator($result, $perPage, $page);

        return response()->json($paginator);
    }

    public function passAll(Request $request, Program $program): JsonResponse
    {
        $validated = $request->validate([
            'category' => ['nullable', 'numeric'],
            'keyword' => ['nullable', 'string']
        ]);

        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;

        $this->updateProgramCertificateProfiles(HasCertificateStatus::$PASS, $program, $keyword, $category);

        return response()->json(['msg' => '합격 처리되었습니다.']);
    }

    /**
     * @param Program $program
     * @param string|null $keyword
     * @param $category
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function searchProgramsCertificateProfiles(Program $program, ?string $keyword, $category)
    {
        $completionQuery = $this->searchQuery(CompletionProfile::query()->from('completion_profiles as profiles'), $program, $category, $keyword, '자격증');
        $qualificationQuery = $this->searchQuery(QualificationProfile::query()->from('qualification_profiles as profiles'), $program, $category, $keyword, '수료증');
        return $completionQuery->union($qualificationQuery)->orderByDesc('created_at');
    }

    public function updateProgramCertificateProfiles($status, Program $program, ?string $keyword, $category)
    {
        $completionQuery = $this->whereForSearch(CompletionProfile::query()->from('completion_profiles as profiles'), $program, $category, $keyword);
        $completionIds = $completionQuery->pluck('profiles.id');
        CompletionProfile::query()->whereIn('id', $completionIds)->update([
            'status' => $status
        ]);

        $qualificationQuery = $this->whereForSearch(QualificationProfile::query()->from('qualification_profiles as profiles'), $program, $category, $keyword);
        $qualificationIds = $qualificationQuery->pluck('profiles.id');
        QualificationProfile::query()->whereIn('id', $qualificationIds)->update([
            'status' => $status
        ]);
    }


    private function searchQuery($baseQuery, $program, $category, $keyword, $type)
    {
        $query = $this->selectForSearch($baseQuery, $type);
        return $this->whereForSearch($query, $program, $category, $keyword);
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
                $query->where('status', '=', HasCertificateStatus::$WAITING);
            } else if ($category == 'ended') {
                $query->whereIn('status', [HasCertificateStatus::$FAILED, HasCertificateStatus::$PASS]);
            }
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

    private function selectForSearch($query, $type)
    {
        return $query->select([
            'profiles.id', 'profiles.status', 'profiles.created_at', DB::raw("'$type' as type"),
            'users.login_id', 'profiles.name', 'users.email', 'users.phone', 'profiles.birthday', 'profiles.university', 'profiles.student_number',
        ]);
    }

}
