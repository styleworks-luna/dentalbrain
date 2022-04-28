<?php

namespace App\Http\Controllers\Admin\Albatalk;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Recruit;
use App\Models\Resume\AppliedResume;
use App\Models\Resume\Resume;
use App\Services\Recruit\ApplyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RecommendResumeController extends Controller
{
    private $applyService;

    public function __construct(ApplyService $applyService)
    {
        $this->applyService = $applyService;
    }


    public function index(Resume $resume)
    {
        $applyList = Recruit::query()
            ->select('id', 'company_name', 'created_at')
            ->where('is_open', '=', 1)
            ->whereDoesntHave('appliedResumes', function ($query) use ($resume) {
                $query->where('resume_id', $resume->id)
                    ->where('status', '=', AppliedResume::STATUS_SUCCESS);
            })
            ->orderByDesc('created_at')
            ->get();

        $cancelList = Recruit::query()
            ->select('id', 'company_name', 'created_at')
            ->whereHas('appliedResumes', function ($query) use ($resume) {
                $query->where('resume_id', $resume->id)
                    ->where('status', '=', AppliedResume::STATUS_SUCCESS);
            })
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'applyList' => $applyList,
            'cancelList' => $cancelList,
        ]);
    }

    public function apply(Request $request, Resume $resume)
    {
        $request->validate([
            'recruits' => ['required', 'array'],
            'recruits.*' => ['numeric'],
        ]);
        $recruits = $request->get('recruits', []);

        foreach ($recruits as $recruitId) {
            try {
                $this->applyService->apply(Recruit::query()->findOrFail($recruitId), true, $resume);
            } catch (ModelNotFoundException $ignored) {
            }
        }

        return response()->json([
            'msg' => '제출되었습니다.',
        ]);
    }

    public function cancel(Request $request, Resume $resume)
    {
        $request->validate([
            'recruits' => ['required', 'array'],
            'recruits.*' => ['numeric'],
        ]);
        $recruits = $request->get('recruits', []);

        foreach ($recruits as $recruitId) {
            try {
                $this->applyService->cancel(Recruit::query()->findOrFail($recruitId), $resume);
            } catch (ModelNotFoundException $ignored) {
            }
        }

        return response()->json([
            'msg' => '제출 취소되었습니다.',
        ]);
    }
}
