<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Comment;
use App\Models\Program\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    //
    public function store(Request $request, Program $program)
    {
        $data = $request->validate([
            'parent_id' => 'numeric',
            'content' => ['required', 'string', 'max:300'],
        ]);

        $data['user_id'] = Auth::id();
        $data['program_id'] = $program->id;

        Comment::create($data);

        return redirect()->with([
            'alert' => '댓글이 등록되었습니다.',
        ]);
    }

    public function delete(Request $request, Program $program, Comment $comment)
    {
        $request->validate([
            'parent_id' => 'numeric',
            'content' => 'required',
        ]);

        if (!Auth::user()->can('delete', $comment)) {
            return redirect()->with([
                'alert' => '권한이 없습니다.'
            ]);
        }
        try {
            DB::beginTransaction();
            $comment->children->delete();
            $comment->delete();
        } catch (\Exception $exception) {
            Log::error('COMMENT DELETE ERROR');
            DB::rollBack();
            return redirect()->with([
                'alert' => '오류가 발생했습니다.'
            ]);
        }

        DB::commit();
        return redirect()->with([
            'alert' => '댓글이 삭제되었습니다.',
        ]);
    }

    public function update(Request $request, Program $program, Comment $comment)
    {
        $data = $request->validate([
            'parent_id' => 'numeric',
            'content' => 'required',
        ]);

        if (!Auth::user()->can('update', $comment)) {
            return redirect()->with([
                'alert' => '권한이 없습니다.'
            ]);
        }

        $data['user_id'] = Auth::id();
        $data['program_id'] = $program->id;

        try {
            DB::beginTransaction();

            Comment::query()->where('id', '=', $comment->id)
                ->update(['content' => $data['content']]);

        } catch (\Exception $exception) {
            Log::error('COMMENT DELETE ERROR');
            DB::rollBack();
            return redirect()->with([
                'alert' => '오류가 발생했습니다.'
            ]);
        }

        DB::commit();
        return redirect()->with([
            'alert' => '댓글이 삭제되었습니다.',
        ]);
    }
}
