<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\Survey;
use Illuminate\Support\Facades\Auth;

class EditController extends Controller
{
    public function showEditForm(Program $program, ProgramStudent $student)
    {
        $surveys = Survey::edit($program->id)
            ->get();

        $programStudent = ProgramStudent::query()->where('ticket_id', '=', $program->ticket->id)
            ->where('user_id', '=', Auth::id())
            ->first();

        return view(viewPrefix() . 'pages.lecture.lecture_edit', [
            'program' => $program,
            'surveys' => $surveys,
            'programStudent' => $programStudent,
        ]);
    }
}
