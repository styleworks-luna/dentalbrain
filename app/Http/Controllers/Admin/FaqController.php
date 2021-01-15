<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manage\Faq;
use App\Services\StatusChange\StatusChangeImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FaqController extends Controller
{

    public function index(){
        $faq = Faq::whereNotNull('id')
            ->orderByDesc('id')
            ->paginate(10);
        return response()->json([
            'faq' => $faq,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'category_id' => 'required | numeric',
            'is_open' => 'required',
        ]);

        $validatedData['user_id'] = auth()->id();
        Faq::create($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '추가되었습니다.',
        ]);
    }

    public function edit(Faq $faq)
    {
        return response()->json([
            'faq' => $faq,
        ]);
    }

    public function update(Faq $faq)
    {
        $v = Validator::make(request()->all(), [
            'question' => 'required',
            'answer' => 'required',
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

    public function statusChange(Faq $faq){
        $statusChangeImpl = new StatusChangeImpl();
        $result = $statusChangeImpl->statusChange($faq,'is_open');
        return $result;
    }
}
