<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Payments\Payment;
use App\Models\Program\ProgramStudent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $data = ProgramStudent::select('user_id','payment_id','ticket_id','expired_at')->where('user_id',Auth::id())
            ->with([
                'payment' => function($query){
                    $query->select('id','totalAmount','status','method','receiptUrl','created_at','deleted_at');
                },
                'ticket.program:id,title,is_online'
            ])->get()->toArray();
        
        return view(viewPrefix() . 'pages.user.mypage.mypage_payment', ['data' => $data]);
    }
}
