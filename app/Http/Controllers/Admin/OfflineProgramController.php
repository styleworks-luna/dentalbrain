<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ProgramFunctions;

class OfflineProgramController extends Controller
{
    use ProgramFunctions;

    public function index()
    {
        return $this->programIndex(0);
    }

}
