<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;

class OnlineProgramController extends Controller
{
    public function index()
    {
        $programs = Program::query()->where('is_online', '=', 1)
            ->orderByDesc('id')->paginate('10');
        return response()->json([
            'programs' => $programs,
        ]);
    }
}
