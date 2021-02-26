<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Payments\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::query()
            ->select('id', 'totalAmount', 'status', 'method', 'receiptUrl', 'requestedAt', 'va_accountNumber', 'va_bank', 'va_customerName', 'va_dueDate')
            ->with(['student' => function ($query) {
                $query->select('id', 'payment_id', 'ticket_id', 'user_id', 'expired_at');
                $query->with(['ticket' => function ($query) {
                    $query->select('id', 'program_id');
                    $query->with('program:id,title,is_online');
                }]);
            }])
            ->whereHas('student', function ($query) {
                $query->where('user_id', Auth::id());
            })->get();

        return view(viewPrefix() . 'pages.user.mypage.mypage_payment', [
            'payments' => $payments,
        ]);
    }
}
