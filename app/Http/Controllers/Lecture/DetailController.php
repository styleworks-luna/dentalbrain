<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;

class DetailController extends Controller
{
    public function detail()
    {
        return view(viewPrefix() . 'pages.lecture.lecture_detail');
    }
}
