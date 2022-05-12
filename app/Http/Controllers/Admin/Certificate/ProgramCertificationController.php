<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\DTO\Certification\ProgramCertificationDTO;
use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use App\Traits\HasCertificateStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProgramCertificationController extends Controller
{
    public function index(Request $request, Program $program)
    {
        $validated = $request->validate([
            'category' => ['nullable', 'numeric'],
            'keyword' => ['nullable', 'string']
        ]);

        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;

        $number = 1;
        $result = collect()
            ->concat($this->searchProgramsCompletionProfiles($keyword, $category, $program)->get())
            ->concat($this->searchProgramsQualificationProfiles($keyword, $category, $program)->get())
            ->sortByDesc('created_at')
            ->map(function ($item) use (&$number) {
                return ProgramCertificationDTO::create($item, $number++);
            });

        return response()->json(
            $result->toArray()
        );
    }

    /**
     * @param $keyword
     * @param $category
     * @param Program $program
     * @return Builder
     */
    private function searchProgramsCompletionProfiles($keyword, $category, Program $program): Builder
    {
        $query = CompletionProfile::query()
            ->with('user')
            ->where('program_id', '=', $program->id)
            ->where('status', '!=', CompletionProfile::$DO_NOT_PAID)
            ->orderBy('created_at');

        if ($category != null) {
            $this->searchProfilesByCategory($query, $category);
        }

        if ($keyword != null) {
            $this->searchProfilesByKeyword($query, $keyword);
        }

        return $query;
    }

    /**
     * @param $keyword
     * @param $category
     * @param Program $program
     * @return Builder
     */
    private function searchProgramsQualificationProfiles($keyword, $category, Program $program): Builder
    {
        $query = QualificationProfile::query()
            ->with('user')
            ->where('program_id', '=', $program->id)
            ->where('status', '!=', QualificationProfile::$DO_NOT_PAID)
            ->orderBy('created_at');

        if ($category != null) {
            $this->searchProfilesByCategory($query, $category);
        }

        if ($keyword != null) {
            $this->searchProfilesByKeyword($query, $keyword);
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string $keyword
     */
    private function searchProfilesByKeyword(Builder $query, string $keyword): void
    {
        $query->where(function ($query) use ($keyword) {
            $query->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('university', 'LIKE', "%$keyword%")
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('email', 'LIKE', "%$keyword%")
                        ->orWhere('phone', 'LIKE', "%$keyword%");
                });
        });
    }

    /**
     * @param Builder $query
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
