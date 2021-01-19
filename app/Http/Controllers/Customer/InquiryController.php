<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-13
 * Time: 오전 10:28
 */

namespace App\Http\Controllers\Customer;

use App\Models\Manage\inquiry;
use App\Models\Manage\InquiryCategory;
use Illuminate\Support\Facades\Validator;

class InquiryController
{
    public function index()
    {
        $categories = InquiryCategory::all();
        return view(viewPrefix() . 'pages.service.inquire', ['categories' => $categories]);
    }

    public function store()
    {
//        $validateData = request()->validate([
//            'name' => 'required',
//            'email' => 'required|email',
//            'phone' => 'required|regex:/^\d{2,3}[-]?\d{3,4}[-]?\d{4}$/',
//            'title' => 'required',
//            'inquire_content' => 'required'
//        ]);

        $validateData = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
        ]);

        inquiry::create($validateData);

        return redirect(request()->url());
    }
}
