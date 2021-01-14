<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manage\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    public function index()
    {
        return view(viewPrefix() . 'pages.test');
    }

    public function show(){
        $notice = Notice::whereNotNull('id')
            ->orderByDesc('id')
            ->paginate(10);
        return response()->json([
            'notice' => $notice,
        ]);
    }

    public function store()
    {
        $v = Validator::make(request()->all(), [
            'title' => 'required',
            'content' => 'required',
            'display_name' => 'required',
            'user_id' => 'required | numeric'
        ]);

        Notice::create($v->validate());

        return response()->json([
            'success' => true,
            'msg' => '추가되었습니다.',
        ]);
    }

    public function edit(Notice $notice)
    {
        return response()->json([
            'data' => $notice,
        ]);
    }

    public function update(Request $request, Notice $notice)
    {
        $v = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'required | numeric'
        ]);

        $validatedData = $v->validate();

        $notice->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '변경이 완료되었습니다.',
        ]);
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();

        return response()->json([
            'success' => true,
            'msg' => '삭제가 완료되었습니다.',
        ]);
    }
}
