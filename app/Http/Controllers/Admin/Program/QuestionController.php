<?php

namespace App\Http\Controllers\Admin\Program;

use App\Http\Controllers\Controller;
use App\Models\Program\LectureQuestion;
use App\Services\Search\SearchService;
use App\Services\StatusChange\StatusChangeImpl;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'question' => $this->search($request),
        ]);
    }

    public function edit(LectureQuestion $question)
    {
        $result = LectureQuestion::query()->where('id', $question->id)
            ->with(['user:id,login_id,name,email,phone',
                'lecture' => function ($query) {
                    $query->select('id', 'program_id');
                    $query->with('program:id,title');
                }])
            ->whereHas('lecture.program', function ($query) {
                $query->select('id', 'title');
            })
            ->first()
            ->toArray();
        return response()->json(['question' => $result]);
    }

    public function update(Request $request, LectureQuestion $question)
    {
        $validatedData = $request->validate([
            'is_answer' => 'required|boolean'
        ]);

        if ($validatedData['is_answer'] == 1) {
            $validatedData['answered_at'] = now();
        }

        $question->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '수정되었습니다.',
        ]);
    }

    public function statusChange(LectureQuestion $question)
    {
        $statusChangeImpl = new StatusChangeImpl();
        if ($question->is_answer == 0) {
            $question->answered_at = now();
        } else {
            $question->answered_at = null;
        }
        $question->save();

        return $statusChangeImpl->statusChange($question, 'is_answer');
    }

    private function search(Request $request)
    {
        $data = LectureQuestion::query()
            ->where(function ($query) use ($request) {
                if ($request->input('keyword')) {
                    $query->where('question', 'like', '%' . $request->input('keyword') . '%');
                }
            })
            ->with('lecture:id,program_id', 'lecture.program:id,title', 'user:id,login_id,email')
            ->orwhereHas('lecture.program', function ($query) use ($request) {
                if ($request->input('keyword')) {
                    $query->where('title', 'like', '%' . $request->input('keyword') . '%');
                }
            });

        if ($request->get('is_answer', 'all') != 'all') {
            $data->where('is_answer', $request->is_answer);
        }

        $result = $data->orderBy('id', 'desc')->paginate(20);

        return $result;
    }
}
