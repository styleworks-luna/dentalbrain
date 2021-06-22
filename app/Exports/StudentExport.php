<?php

namespace App\Exports;

use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\SurveyAnswer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class StudentExport implements FromView
{
    use Exportable;

    private $surveys;
    private $students;
    private $surveyAnswers;

    /**
     * StudentExport constructor.
     * @param Program $program
     */
    public function __construct($surveys, $students, $surveyAnswers)
    {
        $this->surveys = $surveys;
        $this->students = $students;
        $this->surveyAnswers = $surveyAnswers;
    }

    public function view(): View
    {
        return view('excels.students', [
            'surveys' => $this->surveys,
            'students' => $this->students,
            'surveyAnswers' => $this->surveyAnswers,
        ]);
    }
}
