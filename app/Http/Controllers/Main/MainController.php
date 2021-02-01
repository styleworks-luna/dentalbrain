<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Manage\Banner;
use App\Models\Program\Program;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $data['slides'] = Program::main()->take(4)->get();
        $data['bar'] = Banner::public()->where('position', '=', Banner::$POSITION_BAR)->first();
        $data['bottomSlides'] = Banner::public()->where('position', '=', Banner::$POSITION_BOTTOM)->get();

        return view(viewPrefix() . 'index', $data);
    }
}
