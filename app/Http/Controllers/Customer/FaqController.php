<?php

namespace App\Http\Controllers;

use App\Models\Manage\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    //
    private $dbName = 'faqs';

    public function index(){
        return view(viewPrefix() . 'pages.service.faq',['faq' => Faq::all()]);
    }
}
