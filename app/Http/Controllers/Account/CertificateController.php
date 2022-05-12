<?php

namespace App\Http\Controllers\Account;

use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\ProgramStudent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class CertificateController
{
    public function certificatesData()
    {
        return ProgramStudent::query()
            ->select('id', 'user_id', 'payment_id', 'program_id', 'pay_status', 'applied_at')
            ->whereNotIn('pay_status', [ProgramStudent::$PAY_REFUNDED, ProgramStudent::$PAY_BEFORE])
            ->with([
                'payment:id,totalAmount',
                'program' => function (BelongsTo $query) {
                    $query->select('id', 'thumbnail_id', 'title', 'is_online', 'running_time', 'major_category_id', 'minor_category_id', 'price', 'term', 'qualification_id', 'completion_id')
                        ->with('place:id,program_id,address,address_detail,sido,gugun,started_at,ended_at')
                        ->with('thumbnail:id,path,url')
                        ->with(['qualificationProfiles' => function ($query) {
                            $query->select('id', 'program_id', 'file_id', 'status')
                                ->where('status', "!=",QualificationProfile::$DO_NOT_PAID);
                        }])
                        ->with(['completionProfiles' => function ($query) {
                            $query->select('id', 'program_id', 'file_id', 'status')
                                ->where('status',"!=", CompletionProfile::$DO_NOT_PAID);
                        }]);
                },
            ])->where('user_id', '=', Auth::id())
            ->whereHas('program', function (Builder $query) {
                $query->whereNotNull('completion_id')->orWhereNotNull('qualification_id');
            })->orderByDesc('applied_at')->get();
    }
}
