<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Lecture;
use App\Models\Program\LectureProgress;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class WatchController extends Controller
{
    public function watch(Program $program, Lecture $lecture = null)
    {
        if ($program->is_online == 0) {
            // 오프라인 강의
            return redirect()->back()->with(['alert' => '오프라인 강의입니다.']);
        }

        if (Auth::user()->is_admin == true) {
            ProgramStudent::query()->where('program_id', '=', $program->id)
                ->where('user_id', '=', Auth::id())
                ->update(['is_watched' => 1]);
        } else {
            if (!$program->alreadyPaid()) {
                // 미 결제
                return abort(Response::HTTP_UNAUTHORIZED);
            } else if ($program->canOnlineRefund()) {
                // 환불 가능 상태일 경우.
                return view(viewPrefix() . 'pages.lecture.lecture_confirm', [
                    'program' => $program
                ]);
            }
        }

        if ($lecture === null) {
            $now = $program->lectures()->orderBy('id')->first();
        } else {
            $now = $lecture;
        }

        $progress = LectureProgress::query()->where('user_id', '=', Auth::id())
            ->where('youtube_id', '=', $now->youtube_id)
            ->first();

        return view(viewPrefix() . 'pages.lecture.lecture_watch', [
            'program' => $program,
            'lectures' => $program->lectures,
            'now' => $now,
            'progress' => $progress,
        ]);
    }

    public function watched(Program $program, Lecture $lecture = null)
    {
        if ($program->canOnlineRefund()) {
            ProgramStudent::query()->where('program_id', '=', $program->id)
                ->where('user_id', '=', Auth::id())
                ->update(['is_watched' => 1]);
        }
        return redirect()->route('lectures.watch', [$program, $lecture]);
    }

    public function saveProgress(Lecture $lecture, Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'position' => ['required', 'numeric'],
            'is_completed' => ['required', 'boolean'],
            'duration' => ['required', 'numeric']
        ]);
        $data = $validator->validate();

        try {
            LectureProgress::query()->updateOrCreate(
                ['user_id' => Auth::id(), 'youtube_id' => $lecture->youtube_id,],
                ['position' => $data['position'], 'duration' => $data['duration'], 'is_completed' => $data['is_completed']]);

            return response()->json([
                'message' => 'success',
                'lecture' => $lecture->id,
                'position' => $data['position'],
                'is_completed' => $data['is_completed'],
                'duration' => $data['duration'],
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'error',
            ], 500);
        }
    }
}
