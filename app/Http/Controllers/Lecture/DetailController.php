<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Comment;
use App\Models\Program\Program;
use App\Models\Program\UserLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('like');
    }

    public function detail(Program $program)
    {
        $heart = UserLike::query()->where('program_id', '=', $program->id)
            ->where('user_id', '=', Auth::id())
            ->exists();

        $parents = Comment::ofProgram($program->id)
            ->whereNull('parent_id')->with('children')->orderBy('id')->get();

        $children = Comment::ofProgram($program->id)
            ->whereNotNull('parent_id')->orderBy('id')->get();

        if (Auth::check()) {
            $student = $program->students()->where('user_id', '=', Auth::id())
                ->first();
        } else {
            $student = null;
        }

        return view(viewPrefix() . 'pages.lecture.lecture_detail', [
            'program' => $program,
            'heart' => $heart,
            'comments' => $parents,
            'children' => $children,
            'student' => $student,
        ]);
    }

    public function like(Request $request, Program $program)
    {
        if ($request->get('like') === 'true') {
            // 찜
            UserLike::updateOrCreate([
                'user_id' => Auth::id(),
                'program_id' => $program->id,
            ]);
        } elseif ($request->get('like') === 'false') {
            // 찜 해제
            UserLike::query()->where('program_id', '=', $program->id)
                ->where('user_id', '=', Auth::id())->delete();
        } else {
            // 파라미터 없음.
            return response()->json([
                'code' => 3,
                'cnt' => $program->user_like_cnt,
            ], 400);
        }
        $program->refresh();
        // 정상 상황.
        return response()->json([
            'code' => 1,
            'cnt' => $program->user_like_cnt,
        ], 200);
    }
}
