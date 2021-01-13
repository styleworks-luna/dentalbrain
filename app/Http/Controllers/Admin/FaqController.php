<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manage\Faq;
use Illuminate\Support\Facades\Validator;


class FaqController extends Controller
{
    public function store()
    {
        $v = Validator::make(request()->all(), [
            'question' => 'required',
            'answer' => 'required',
            'category_id' => 'required | numeric'
        ]);

        Faq::create($v->validate());

        return response()->json([
            'success' => true,
            'msg' => '추가되었습니다.',
        ]);
    }

    public function edit(Faq $faq)
    {
        return response()->json([
            'data' => $faq,
        ]);
    }

    public function update(Faq $faq)
    {
        $v = Validator::make(request()->all(), [
            'question' => 'required',
            'answer' => 'required',
            'category_id' => 'required | numeric'
        ]);

        $validatedData = $v->validate();

        $faq->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '변경이 완료되었습니다.',
        ]);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'success' => true,
            'msg' => '삭제가 완료되었습니다.',
        ]);
    }
}
