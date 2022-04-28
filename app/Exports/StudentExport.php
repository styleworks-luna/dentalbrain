<?php

namespace App\Exports;

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
     * @param $surveys
     * @param $students
     * @param $surveyAnswers
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
