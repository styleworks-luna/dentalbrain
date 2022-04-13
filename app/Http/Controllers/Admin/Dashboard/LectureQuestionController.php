<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Program\LectureQuestion;

class LectureQuestionController extends Controller
{
    public function index()
    {
        $questions = LectureQuestion::query()
            ->with('lecture:id,program_id', 'lecture.program:id,title', 'user:id,login_id')
            ->where('is_answer', false)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'questions' => $questions
        ]);
    }
}
