<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Lecture;
use App\Models\Program\Program;
use Symfony\Component\HttpFoundation\Response;

class WatchController extends Controller
{
    public function watch(Program $program, Lecture $lecture = null)
    {
        if (!$program->alreadyPaid()) {
            return abort(Response::HTTP_UNAUTHORIZED);
        }
        if ($program->is_online == 0) {
            return redirect()->back()->with(['alert' => '오프라인 강의입니다.']);
        }

        if ($lecture === null) {
            $now = $program->lectures()->orderBy('id')->first();
        } else {
            $now = $lecture;
        }

        return view(viewPrefix() . 'pages.lecture.lecture_watch', [
            'program' => $program,
            'lectures' => $program->lectures,
            'now' => $now,
        ]);
    }
}
