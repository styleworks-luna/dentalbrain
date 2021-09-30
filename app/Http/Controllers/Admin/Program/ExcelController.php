<?php

namespace App\Http\Controllers\Admin\Program;

use App\Exports\StudentExport;
use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export(Request $request, Program $program)
    {
        $program->with(['surveys', 'students', 'answers']);

        $surveys = $program->surveys()->whereNull('parent_id')
            // 순서 유지 중요!
            ->orderBy('id')
            ->withCount('choices')
            ->get();
        $students = $program->students()->with('user')->get();
        $surveyAnswers = $program->answers()->get();


        $filename = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $program->title);
        $filename = mb_ereg_replace("([\.]{2,})", '', $filename);

        return Excel::download(new StudentExport($surveys, $students, $surveyAnswers), $filename . ' 명단.xlsx');
    }
}
