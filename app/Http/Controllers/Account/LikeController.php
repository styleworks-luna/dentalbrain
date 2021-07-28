<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class LikeController extends Controller
{
    public function likeLectures(Request $request)
    {
        $data = $request->validate([
            'order' => ['required', Rule::in(['online', 'offline', 'newest'])],
        ]);

        /** @var User $user */
//        $user = User::query()->find(Auth::id());
        $user = Auth::user();
        if ($user == null) {
            Log::error('error in like programs', [$request->all(), Auth::id(),session()->all()]);
            return response()->json([], 403);
        }

        $programs = $user->likePrograms()
            ->with([
                'thumbnail' => function ($query) {
                    $query->select(['id', 'url', 'name']);
                }, 'place' => function ($query) {
                    $query->select(['id', 'program_id', 'address', 'address_detail',
                        'started_at', 'ended_at']);
                }])
            ->where('is_open', '=', 1)
            ->orderByDesc('programs.created_at');


        if ($data['order'] == 'online') {
            $programs = $programs->where('is_online', '=', 1);
        } elseif ($data['order'] == 'offline') {
            $programs = $programs->where('is_online', '=', 0);
        }

        $programs = $programs->paginate(10, [
            'programs.id', 'programs.description', 'programs.major_category_id',
            'programs.minor_category_id', 'programs.title',
            'programs.price', 'programs.running_time', 'programs.thumbnail_id',
            'programs.is_online', 'programs.is_free']);


        return response()->json($programs);
    }
}
