<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;

class ApplyController extends Controller
{
    public function apply(Program $program)
    {
        return view(viewPrefix() . 'pages.lecture.lecture_apply', ['program' => $program]);
    }
}
