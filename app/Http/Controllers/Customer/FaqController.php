<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Manage\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all()->where('is_open','1');
        return view(viewPrefix() . 'pages.service.faq', ['faqs' => $faqs]);
    }
}
