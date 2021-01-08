<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;

class ApplyController extends Controller
{
    public function apply()
    {
        return view(viewPrefix() . 'pages.lecture.lecture_apply');
    }
}
