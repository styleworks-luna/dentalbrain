<?php

namespace App\Http\Controllers\Albatalk\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume\Ability\Ability;
use App\Models\Resume\Ability\AbilityCategory;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function createForm()
    {
        return view(viewPrefix() . 'pages.albatalk.albatalk_resume')->with([
            'leftList' => AbilityCategory::query()->where('id', '<=', '5')->with('abilities')->get(),
            'rightList' => AbilityCategory::query()->where('id', '>', '5')->with('abilities')->get()
        ]);
    }

    public function create(Request $request)
    {
        ddd($request->all());
    }
}
