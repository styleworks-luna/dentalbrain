<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Program\ProgramStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProgramController extends Controller
{

    public function index()
    {
        return view(viewPrefix() . 'pages.user.mypage.mypage_lecture');
    }

    public function lecturesData(Request $request)
    {
        $request->validate([
            'order' => ['required', Rule::in(['online', 'offline', 'newest'])],
        ]);

        //TODO: 사용자에 따른 강의 구분 정보 넣기.
        $queryBuilder = ProgramStudent::query()->select('id', 'user_id', 'payment_id', 'ticket_id', 'expired_at', 'is_watched', 'pay_status','applied_at')
            ->whereIn('pay_status', [ProgramStudent::$PAY_PAID, ProgramStudent::$PAY_IN_REFUND_PROCESS])
            ->with([
                'payment:id,totalAmount,receiptUrl,method,status',
                'ticket.program' => function ($query) {
                    $query->select('id', 'thumbnail_id', 'title', 'is_online', 'running_time', 'major_category_id', 'minor_category_id')
                        ->with('place:id,program_id,address,address_detail,sido,gugun,started_at,ended_at')
                        ->with('thumbnail:id,path,url')
                        ->with('lectures:id,program_id');
                },
                // 기본 정렬
            ])->orderByDesc('applied_at')
            ->where('user_id', '=', Auth::id());

        if ($request->input('order', 'newest') == 'online') {
            // 온라인 정렬일 경우.
            $queryBuilder = $queryBuilder->whereHas('ticket.program', function ($query) {
                $query->where('is_online', '1');
            });
        } elseif ($request->input('order', 'newest') == 'offline') {
            // 오프라인 정렬일 경우.
            $queryBuilder = $queryBuilder->whereHas('ticket.program', function ($query) {
                $query->where('is_online', '0');
            });
        }

        return response()->json(['data' => $queryBuilder->paginate('10')]);
    }
}
