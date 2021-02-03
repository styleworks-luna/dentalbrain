<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manage\Faq;
use App\Models\Manage\FaqCategory;
use App\Services\Search\SearchService;
use App\Services\StatusChange\StatusChangeImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    private $search;
    public function __construct()
    {
        $this->search = new SearchService(Faq::query());
    }


    public function index(Request $request)
    {
        return response()->json([
            'faq' => $this->search($request),
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
        $validatedData['user_id'] = Auth::id();

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
            'category_id' => 'required | numeric',
            'is_open' => 'required'
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

    public function statusChange(Faq $faq)
    {
        $statusChangeImpl = new StatusChangeImpl();
        return $statusChangeImpl->statusChange($faq,'is_open');
    }

    public function getFaqCategory()
    {
        return response()->json([
            'faqCategory' => FaqCategory::all()
        ]);
    }

    private function search(Request $request){
        $this->search
            ->addKeyword('question',$request->keyword)
            ->addKeyword('answer', $request->keyword);

        $result = $this->search->search()->orderBy('id','desc')->paginate('10');
        return $result;
    }
}
