<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payments\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::query()
            ->orderByDesc('id')
            ->with(['student.ticket.program' => function ($query) {
                $query->select('id', 'is_online', 'title');
            }])
            ->select('id','totalAmount','receiptUrl','method','status','requestedAt','approvedAt')
            ->paginate(10);

        return response()->json([
            'payments' => $payments,
        ]);
    }
}
