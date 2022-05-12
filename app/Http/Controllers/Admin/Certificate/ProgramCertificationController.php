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
use Illuminate\Support\Facades\Log;

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

        return response()->json($result);
    }

    public function passAll(Request $request, Program $program): JsonResponse
    {
        $validated = $request->validate([
            'category' => ['nullable', 'numeric'],
            'keyword' => ['nullable', 'string']
        ]);

        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;

        try {
            DB::beginTransaction();
            $this->updateProgramCertificateProfiles(HasCertificateStatus::$PASS, $program, $keyword, $category);

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('CERTIFICATE UPDATE ERROR', [$exception]);
            return response()->json(['msg' => '오류가 발생하였습니다.']);
        }
        
        DB::commit();
        return response()->json(['msg' => '합격 처리되었습니다.']);
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

        $qualificationQuery = $this->selectForSearch(QualificationProfile::query()->from('qualification_profiles as profiles'), '수료증');
        $qualificationQuery = $this->whereForSearch($qualificationQuery, $program, $category, $keyword);
        $unionized = $completionQuery->union($qualificationQuery)->orderByDesc('created_at');

        $perPage = 10;
        $page = Paginator::resolveCurrentPage();

        $result = $unionized
            ->offset($perPage * ($page - 1))
            ->limit($perPage)
            ->get();

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
