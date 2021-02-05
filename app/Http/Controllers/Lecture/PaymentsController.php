<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\SuccessPayments;
use App\Models\Program\Program;
use App\Services\Program\OfflineProgramConcrete;
use App\Services\Program\OnlineProgramConcrete;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function result(SuccessPayments $request, Program $program)
    {
        logger($request->all());

        return view(viewPrefix() . 'pages.lecture.lecture_success');
    }

    public function showPaymentForm(Request $request, Program $program)
    {

        if ($program->is_online == 1) {
            $programService = new OnlineProgramConcrete();
        } else {
            $programService = new OfflineProgramConcrete();
        }

        $programDetail = $programService->getProgramDetail($program);

        return view(viewPrefix() . 'pages.lecture.lecture_payment', [
            'program' => $programDetail['program'],
            'surveys' => $programDetail['surveys']
        ]);
    }

}
