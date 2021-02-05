<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\SuccessPayments;
use App\Models\Program\Program;

class PaymentsController extends Controller
{
    public function success(SuccessPayments $request, Program $program)
    {
        logger($request->all());

        return view(viewPrefix() . 'pages.lecture.lecture_success');
    }
}
