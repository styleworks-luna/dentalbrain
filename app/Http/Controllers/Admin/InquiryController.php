<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-13
 * Time: 오전 10:32
 */

namespace App\Http\Controllers\Admin;
use App\Models\Manage\Inquiry;

class InquiryController {
    public function edit(Inquiry $inquiry){
        return response()->json([
           'inquiry' => $inquiry
        ]);
    }
}