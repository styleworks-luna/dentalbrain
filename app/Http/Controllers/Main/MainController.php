<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Manage\Banner;
use App\Models\Manage\Faq;
use App\Models\Manage\Notice;
use App\Models\Program\Program;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $data['slides'] = Banner::public()->where('category_id', '=', Banner::$POSITION_TOP)->take(8)->get();
        $data['bar'] = Banner::public()->where('category_id', '=', Banner::$POSITION_BAR)->first();
        $data['bottomSlides'] = Banner::public()->where('category_id', '=', Banner::$POSITION_BOTTOM)->get();
        $data['recommends'] = Banner::public()->where('category_id', '=', Banner::$POSITION_RECOMMEND)->get();
        $data['notices'] = Notice::public()->take(3)->get();
        $data['faqs'] = Faq::public()->take(3)->get();

        return view(viewPrefix() . 'index', $data);
    }
}
