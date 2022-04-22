<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Payments\TossPayment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = TossPayment::query()
            //->select('id', DB::raw("JSON_UNQUOTE(JSON_EXTRACT(full_response, '$.cancels[0]')) as cancel"), DB::raw("JSON_UNQUOTE(JSON_EXTRACT(full_response, '$.cancels[0].canceledAt')) as canceledAt"),'totalAmount', 'status', 'method', 'receiptUrl', 'requestedAt', 'va_accountNumber', 'va_bank', 'va_customerName', 'va_dueDate')
            ->select('id', 'full_response', 'totalAmount', 'status', 'method', 'receiptUrl', 'requestedAt', 'va_accountNumber', 'va_bank', 'va_customerName', 'va_dueDate')
            ->with(['student' => function ($query) {
                $query->select('id', 'payment_id', 'program_id', 'user_id', 'expired_at')
                    ->with(['program' => function ($query) {
                        $query->select('id', 'title', 'is_online', 'thumbnail_id', 'price', 'minor_category_id')
                            ->with('thumbnail', 'minorCategory');
                    }]);
            }])
            ->with(['membership' => function ($query) {
                $query->select('id', 'payment_id', 'user_id', 'applied_days');
            }])
            ->with(['recruit' => function ($query) {
                $query->select('id', 'payment_id', 'user_id', 'company_name');
            }])
            ->where(function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('user_id', Auth::id());
                })->orWhereHas('membership', function ($query) {
                    $query->where('user_id', Auth::id());
                })->orWhereHas('recruit', function ($query) {
                    $query->where('user_id', Auth::id());
                });
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
