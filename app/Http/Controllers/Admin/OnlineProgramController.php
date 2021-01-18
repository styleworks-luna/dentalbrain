<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ProgramFunctions;
use Illuminate\Http\Request;

class OnlineProgramController extends Controller
{
    use ProgramFunctions;

    public function index()
    {
        return $this->programIndex(1);
    }

}
