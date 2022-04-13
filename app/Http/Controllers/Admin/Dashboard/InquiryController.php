<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Manage\Inquiry;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::query()
            ->where('is_answer', false)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'inquiries' => $inquiries,
        ]);
    }
}
