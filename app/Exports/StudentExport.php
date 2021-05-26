<?php

namespace App\Exports;

use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\SurveyAnswer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentExport implements FromView
{
    use Exportable;


    private $program;

    /**
     * StudentExport constructor.
     * @param Program $program
     */
    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    public function view(): View
    {
        $surveys = $this->program->surveys()->whereNull('parent_id')
            // 순서 유지 중요!
            ->orderBy('id')
            ->withCount('choices')
            ->get();
        $students = ProgramStudent::query()->where('program_id', '=', $this->program->id)->get();
        $surveyAnswers = SurveyAnswer::query()->whereIn('survey_id', $surveys->pluck('id'))->get();
        return view('excels.students', [
            'surveys' => $surveys,
            'students' => $students,
            'surveyAnswers' => $surveyAnswers,
        ]);
    }
}
