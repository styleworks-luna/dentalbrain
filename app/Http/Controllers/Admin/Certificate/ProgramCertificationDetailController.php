<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CompletionProfile;
use App\Models\Certificate\QualificationProfile;
use App\Models\Program\Program;
use Illuminate\Http\Request;

class ProgramCertificationDetailController extends Controller
{
    public function getCompletionProfile(Request $request, CompletionProfile $profile)
    {
        return response()->json($profile->load('file','user')->toArray());
    }

    public function getQualificationProfile(Request $request, Program $program, QualificationProfile $profile)
    {
        return response()->json($profile->load('file','user')->toArray());
    }
}
