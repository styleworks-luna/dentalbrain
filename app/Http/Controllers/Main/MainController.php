<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Manage\Banner;

use App\Models\Manage\Notice;
use App\Models\Program\Program;
use Illuminate\Http\Request;
use App\Models\Manage\Faq;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $data['slides'] = Program::main()->take(4)->get();
        $data['bar'] = Banner::public()->where('position', '=', Banner::$POSITION_BAR)->first();
        $data['recommendSlides'] = Banner::public()->where('position','=',Banner::$POSITION_RECOMMEND)->get();
        $data['bottomSlides'] = Banner::public()->where('position', '=', Banner::$POSITION_BOTTOM)->get();

        $data['notices'] = Notice::public()->limit(3)->get();
        $data['faqs'] = Faq::public()->limit(3)->get();
        return view(viewPrefix() . 'index', $data);
    }
}
