<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LikeController extends Controller
{
    public function likeLectures(Request $request)
    {
        $data = $request->validate([
            'order' => ['required', Rule::in(['online', 'offline', 'newest'])],
        ]);

        /** @var User $user */
        $user = User::query()->find(Auth::id());

        return response()->json([
            'programs' => $user->likePrograms()->with('thumbnail:id,url,name')->get([
                    'programs.id', 'programs.description', 'programs.major_category_id','programs.minor_category_id',
                'programs.price','programs.running_time','programs.thumbnail_id','programs.is_online','programs.is_free'

                ]),
            'likes' => $user->likes()->get(),
        ]);

    }
}
