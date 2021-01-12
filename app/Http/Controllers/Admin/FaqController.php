<?php

namespace App\Http\Controllers;

use App\Models\Manage\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    //
    private $dbName = 'faqs';

    public function store(){
        $v = Validator::make(request()->all(),[
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
}
