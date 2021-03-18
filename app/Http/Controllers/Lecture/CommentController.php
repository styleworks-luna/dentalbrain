<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Comment;
use App\Models\Program\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    //
    public function store(Request $request, Program $program)
    {
        $v = Validator::make($request->all(), [
            'parent_id' => ['numeric', 'nullable'],
            'content' => ['required', 'string', 'max:200'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'msg' => $v->errors()->get('content'),
            ], 400);
        }

        $data = $v->validated();

        $data['user_id'] = Auth::id();
        $data['program_id'] = $program->id;

        Comment::create($data);

        return response()->json([
            'msg' => '댓글이 등록되었습니다.',
        ]);
    }

    public function delete(Request $request, Program $program, Comment $comment)
    {
        if (!Auth::user()->can('delete', $comment)) {
            return response()->json([
                'msg' => '권한이 없습니다.'
            ], 403);
        }
        try {
            DB::beginTransaction();

            $comment->children()->delete();
            $comment->delete();

        } catch (\Exception $exception) {
            Log::error('COMMENT DELETE ERROR', [$exception]);
            DB::rollBack();
            return response()->json([
                'msg' => '오류가 발생했습니다.'
            ], 500);
        }

        DB::commit();
        return response()->json([
            'msg' => '댓글이 삭제되었습니다.',
        ]);
    }

    public function update(Request $request, Program $program, Comment $comment)
    {
        $v = Validator::make($request->all(), [
            'parent_id' => ['numeric', 'nullable'],
            'content' => ['required', 'string', 'max:200'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'msg' => $v->errors()->get('content'),
            ], 400);
        }

        $data = $v->validated();

        if (!Auth::user()->can('update', $comment)) {
            return response()->json([
                'msg' => '권한이 없습니다.'
            ], 403);
        }

        $data['user_id'] = Auth::id();
        $data['program_id'] = $program->id;

        try {
            DB::beginTransaction();

            Comment::query()->where('id', '=', $comment->id)
                ->update(['content' => $data['content']]);

        } catch (\Exception $exception) {
            Log::error('COMMENT UPDATE ERROR', [$exception]);
            DB::rollBack();
            return response()->json([
                'msg' => '오류가 발생했습니다.'
            ], 500);
        }

        DB::commit();
        return response()->json([
            'msg' => '댓글이 수정되었습니다.',
        ]);
    }
}
