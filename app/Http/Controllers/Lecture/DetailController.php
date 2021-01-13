<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;

class DetailController extends Controller
{
    public function detail(Program $program)
    {

        return view(viewPrefix() . 'pages.lecture.lecture_detail', ['program' => $program]);
    }
}
