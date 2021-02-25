<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payments\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::query()->orderByDesc('id')->paginate(10);

        return response()->json([
            'payments' => $payments,
        ]);
    }
}
