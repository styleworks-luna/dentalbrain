<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Manage\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view(viewPrefix() . 'pages.service.faq', ['faqs' => $faqs]);
    }
}
