<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manage\Notice;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    public function index()
    {
        return view(viewPrefix() . 'pages.test');
    }

    public function store(){
        $v = Validator::make(request()->all(),[
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

    public function edit($number){
        return response()->json([
            'data' => Notice::findOrFail($number)->first()
        ]);
    }

    public function update(){
        $v = Validator::make(request()->all().[
            'title' => 'required',
            'content' => 'required',
            'display_name' => 'required',
            'user_id' => 'required | numeric'
        ]);

        $validatedData = $v->validate();

        $notice = Notice::find(request('id'));

        $notice->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '변경이 완료되었습니다.',
        ]);
    }

    public function destroy(Notice $notice){
        $notice::delete();

        return response()->json([
            'success' => true,
            'msg' => '삭제가 완료되었습니다.',
        ]);
    }
}
