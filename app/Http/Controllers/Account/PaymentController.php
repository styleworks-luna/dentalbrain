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

        $data = Payment::query()->select('id','totalAmount','status','method','receiptUrl','created_at','deleted_at')
            ->with(['students'=>function($query){
                $query->select('id','payment_id','ticket_id','user_id','expired_at');
                $query->with(['ticket' => function($query){
                    $query->select('id','program_id');
                    $query->with('program:id,title,is_online');
                }]);
            }])
            ->whereHas('students',function($query){
                $query->where('user_id',Auth::id());
            })->get()->toArray();

        return view(viewPrefix() . 'pages.user.mypage.mypage_payment', ['data' => $data]);
    }
}
