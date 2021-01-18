<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use App\Traits\ProgramFunctions;
use Illuminate\Http\Request;

class OfflineProgramController extends Controller
{
    use ProgramFunctions;

    public $is_online = false;

    public function index()
    {
        return $this->programIndex();
    }

    public function students(Program $program)
    {
        return $this->getStudentInfo($program);
    }

    public function store(Request $request)
    {
        $this->validate($request);
    }

    function additionalValidate(Request $request)
    {
        // 추가적으로 validation 필요한 것들.l
        return [];
    }
}
