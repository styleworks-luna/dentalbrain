<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\LectureQuestion;

class QuestionController extends Controller
{
    public function index()
    {
       $data = LectureQuestion::query()->with('lecture:id,title','answer')->get()->toArray();
        var_dump($data);
    }
}
