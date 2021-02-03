<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Services\Program\OfflineProgramConcrete;
use App\Services\Program\OnlineProgramConcrete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplyController extends Controller
{
    public function showApplyForm(Program $program)
    {
        if ($program->is_online == 1) {
            $programService = new OnlineProgramConcrete();
        } else {
            $programService = new OfflineProgramConcrete();
        }

        $programDetail = $programService->getProgramDetail($program);

        return view(viewPrefix() . 'pages.lecture.lecture_apply', [
            'program' => $programDetail['program'],
            'surveys' => $programDetail['surveys']
        ]);
    }

    public function apply(Request $request, Program $program)
    {
        ddd($request->all());
    }
}
