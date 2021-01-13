<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Models\Program\UserLike;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function detail(Program $program)
    {
        return view(viewPrefix() . 'pages.lecture.lecture_detail', ['program' => $program]);
    }

    public function like(Program $program)
    {
        UserLike::updateOrCreate([
            'user_id' => Auth::id(),
            'program_id' => $program->id,
        ]);

        return response()->json([
            'code' => 1,
            'msg' => '찜',
        ]);
    }

    public function unlike(Program $program)
    {
        UserLike::query()->where('program_id','=',$program->id)
            ->where('user_id','=',Auth::id())->delete();

        return response()->json([
            'code' => 1,
            'msg' => '안찜',
        ]);
    }
}
