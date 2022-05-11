<?php

namespace App\Http\Controllers\Admin\Certificate;

use App\DTO\Certification\ProgramCertificationDTO;
use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use Illuminate\Http\Request;

class ProgramCertificationController extends Controller
{
    public function index(Request $request, Program $program)
    {
        $program->load(['completionProfiles', 'qualificationProfiles']);
        
        $number = 1;
        $collection1 = $program->completionProfiles->map(function ($item) use (&$number) {
            return ProgramCertificationDTO::create($item, $number++);
        });
        $collection2 = $program->qualificationProfiles->map(function ($item) use (&$number) {
            return ProgramCertificationDTO::create($item, $number++);
        });

        return response()->json([
            collect($collection1->values(), $collection2->values())
        ]);
    }
}
