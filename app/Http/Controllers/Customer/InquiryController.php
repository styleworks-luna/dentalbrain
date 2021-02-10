<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-13
 * Time: 오전 10:28
 */

namespace App\Http\Controllers\Customer;

use App\Models\Manage\Inquiry;
use App\Models\Manage\InquiryCategory;
use Illuminate\Validation\Rule;

class InquiryController
{
    public function index()
    {
        $categories = InquiryCategory::all();
        return view(viewPrefix() . 'pages.service.inquire', ['categories' => $categories]);
    }

    public function store()
    {
        //'phone' => 'required|regex:/^\d{2,3}[-]?\d{3,4}[-]?\d{4}$/',
        $validateData = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'title' => ['required','string'],
            'content' => ['required','string'],
            'category_id' => ['required', Rule::exists('inquiry_categories', 'id')],
        ]);

        Inquiry::create($validateData);

        return redirect(request()->url())->with('alert','문의가 접수되었습니다.');
    }
}
