<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Recruit;
use Illuminate\Support\Facades\Auth;

class RecruitController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $recruits = Recruit::query()->where('user_id', $userId)
            ->select('id', 'company_name', 'sido', 'gugun', 'started_at', 'ended_at', 'expired_at', 'main_file_id')
            ->with('file:id,url')
            ->orderByDesc('expired_at')
            ->get();

        return response()->json([
            '$recruits' => $recruits
        ]);
    }
}
