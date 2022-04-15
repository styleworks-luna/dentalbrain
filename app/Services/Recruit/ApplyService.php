<?php

namespace App\Services\Recruit;

use App\DTO\Recruit\RecruitAuthority;
use App\Models\Recruit\Recruit;
use App\Models\Resume\AppliedResume;
use App\Models\Resume\Resume;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplyService
{
    /**
     * @param Recruit $recruit
     * @param bool $isRecommended
     * @return Builder|Model
     */
    public function apply(Recruit $recruit, bool $isRecommended = false)
    {
        $resume = Resume::query()->where('user_id', '=', Auth::id())->first('id');

        return AppliedResume::query()->updateOrCreate([
            'recruit_id' => $recruit->id,
            'resume_id' => $resume->id,
        ], [
            'status' => AppliedResume::STATUS_SUCCESS,
            'applied_at' => now(),
            'canceled_at' => null,
            'is_recommended' => $isRecommended,
        ]);
    }

    public function applied(Recruit $recruit): bool
    {
        $resume = Resume::query()->where('user_id', '=', Auth::id())->first('id');
        if ($resume == null) {
            return false;
        }

        return AppliedResume::query()
            ->where('resume_id', '=', $resume->id)
            ->where('recruit_id', '=', $recruit->id)
            ->where('status', '=', AppliedResume::STATUS_SUCCESS)
            ->exists();
    }
}
