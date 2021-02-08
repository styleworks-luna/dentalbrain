<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\SuccessPayments;
use App\Models\Program\Program;
use App\Models\Program\Survey\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    public function result(SuccessPayments $request, Program $program)
    {
        logger($request->all());

        return view(viewPrefix() . 'pages.lecture.lecture_success');
    }

    public function showPaymentForm(Request $request, Program $program)
    {
        $surveys = Survey::query()
            ->with(['choices',
                'answers' => function ($query) {
                    $query->where('user_id', '=', Auth::id());
                }, 'answer' => function ($query) {
                    $query->where('user_id', '=', Auth::id());
                }])
            ->where('program_id', '=', $program->id)
            ->whereNull('parent_id')
            ->get();

        return view(viewPrefix() . 'pages.lecture.lecture_payment', [
            'program' => $program,
            'surveys' => $surveys,
        ]);
    }

}
