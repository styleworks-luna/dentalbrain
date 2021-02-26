<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CancelController extends Controller
{
    public function cancel(Request $request)
    {
        // 유저 측에서 환불 요청할 경우 이곳을 거침.
        // 1. validation ( 권한이 되는지, parameter 정확한지 )
        // 2. 관련 db 삭제
        // 3. Toss 결제 취소 콜.
        // return.
    }
}
