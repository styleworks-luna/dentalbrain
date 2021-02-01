<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Manage\Banner;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {

        $data['topSlides'] = Banner::public()->where('position','=',Banner::$POSITION_TOP)->get();
        $data['bar'] = Banner::public()->where('position', '=', Banner::$POSITION_BAR)->first();
        $data['recommendSlides'] = Banner::public()->where('position','=',Banner::$POSITION_RECOMMEND)->get();
        $data['bottomSlides'] = Banner::public()->where('position', '=', Banner::$POSITION_BOTTOM)->get();
        return view(viewPrefix() . 'index', $data);
    }
}
