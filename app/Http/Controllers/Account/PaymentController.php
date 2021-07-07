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
            //->select('id', DB::raw("JSON_UNQUOTE(JSON_EXTRACT(full_response, '$.cancels[0]')) as cancel"), DB::raw("JSON_UNQUOTE(JSON_EXTRACT(full_response, '$.cancels[0].canceledAt')) as canceledAt"),'totalAmount', 'status', 'method', 'receiptUrl', 'requestedAt', 'va_accountNumber', 'va_bank', 'va_customerName', 'va_dueDate')
            ->select('id', 'full_response', 'totalAmount', 'status', 'method', 'receiptUrl', 'requestedAt', 'va_accountNumber', 'va_bank', 'va_customerName', 'va_dueDate')
            ->with(['student' => function ($query) {
                $query->select('id', 'payment_id', 'program_id', 'user_id', 'expired_at')
                    ->with(['program' => function ($query) {
                        $query->select('id', 'title', 'is_online', 'thumbnail_id', 'price')
                            ->with('thumbnail');
                    }]);
            }])
            ->whereHas('student', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereHas('membership', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('id', 'desc')->paginate(10);

        foreach ($payments as $payment) {
            $payment->full_response = json_decode($payment->full_response);
        }

        return view(viewPrefix() . 'pages.user.mypage.mypage_payment', [
            'payments' => $payments,
        ]);
    }
}
