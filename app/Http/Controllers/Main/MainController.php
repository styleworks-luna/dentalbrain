<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Manage\Banner;
use App\Models\Manage\Faq;
use App\Models\Manage\Notice;
use App\Models\Program\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $data['slides'] = Program::main()->take(4)->get();
        $data['bar'] = Banner::public()->where('position', '=', Banner::$POSITION_BAR)->first();
        $data['bottomSlides'] = Banner::public()->where('position', '=', Banner::$POSITION_BOTTOM)->get();
        $data['notices'] = Notice::public()->take(3)->get();
        $data['faqs'] = Faq::public()->take(3)->get();
        return view(viewPrefix() . 'index', $data);
    }

    public function lectures(Request $request)
    {
        $v = Validator::make($request->all(), [
            'category_id' => ['required', Rule::exists('program_major_categories', 'id')]
        ]);

        $v->validate();

        $programs = Program::public()->where('major_category_id', '=', $request->get('category_id', 1))
            ->take(9)->get();
        return response()->json(
            $programs
        );
    }
}
