<?php

namespace App\Http\Controllers\Customer;

use App\Models\Manage\Faq;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index(){
        return view(viewPrefix() . 'pages.service.faq',['faq' => Faq::all()]);
    }
}
