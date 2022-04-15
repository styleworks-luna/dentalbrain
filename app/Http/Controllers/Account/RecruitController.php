<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RecruitController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $recruits = Recruit::query()->where('user_id', $userId)
            ->select('id', 'company_name', 'sido', 'gugun', 'started_at', 'ended_at', 'main_file_id', 'expired_at')
            ->with('file:id,url')
            ->orderByDesc('expired_at')
            ->get()->map(function ($item, $key) {
                $item->remain_day = now()->diffInDays($item['expired_at'], false);
                return $item;
            });

        return response()->json([
            'recruits' => $recruits,
        ]);
    }
}
