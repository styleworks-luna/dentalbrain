<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\DTO\Certification\ProgramCertificationDTO;
use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProgramCertificationController extends Controller
{
    public function index(Request $request, Program $program)
    {

        $result = $this->searchProgramsCertificateProfiles($request, $program);

        return response()->json(
            $result->toArray()
        );
    }

    /**
     * @param Request $request
     * @param Program $program
     * @return Collection
     */
    private function searchProgramsCertificateProfiles(Request $request, Program $program): Collection
    {
        $validated = $request->validate([
            'category' => ['nullable', 'numeric'],
            'keyword' => ['nullable', 'string']
        ]);
        $keyword = $validated['keyword'] ?? null;
        $category = $validated['category'] ?? null;

        $qualificationQuery = QualificationProfile::query()
            ->with('user')
            ->where('program_id', '=', $program->id);

        $completionQuery = CompletionProfile::query()
            ->with('user')
            ->where('program_id', '=', $program->id);

        if ($category != null) {
            $this->searchProfilesByCategory($qualificationQuery, $keyword);
            $this->searchProfilesByCategory($completionQuery, $keyword);
        }

        if ($keyword != null) {
            $this->searchProfilesByKeyword($qualificationQuery, $keyword);
            $this->searchProfilesByKeyword($completionQuery, $keyword);
        }

        $number = 1;

        return collect()->concat(
            $completionQuery->get()->map(function ($item) use (&$number) {
                return ProgramCertificationDTO::create($item, $number++);
            })
        )->concat(
            $qualificationQuery->get()->map(function ($item) use (&$number) {
                return ProgramCertificationDTO::create($item, $number++);
            })
        );
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
     * @param $keyword
     */
    private function searchProfilesByCategory(Builder $query, $keyword): void
    {
    }

}
