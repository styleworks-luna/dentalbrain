<?php

namespace App\Http\Controllers\Admin\Program;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Models\Program\Survey\Survey;
use App\Models\User;

class SurveyController extends Controller
{
    public function index(Program $program, User $user){
        return response()->json(['result' => Survey::ResultWithUser($program->id,$user->id)->get()->toArray()]);
    }
}
