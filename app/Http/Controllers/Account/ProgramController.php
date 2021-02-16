<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Program\ProgramStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ProgramController extends Controller
{

    public function index()
    {
        return view(viewPrefix() . 'pages.user.mypage.mypage_lecture');
    }

    public function lecturesData(Request $request)
    {
        $data = ProgramStudent::query()->select('id','user_id','payment_id','ticket_id','expired_at')
        ->with([
            'payment:id,totalAmount,receiptUrl,method,status',
            'ticket.program' => function($query){
                $query->select('id','thumbnail_id','title','is_online','running_time','major_category_id','minor_category_id')
                ->with('place:id,program_id,sido,gugun,started_at,ended_at')
                ->with('thumbnail:id,path,url');
            },

        ])->where('user_id','=',Auth::id())->get();

        $data = $this->setOrder($data, $request->order);

        return response()->json(['data'=> $data]);
    }


    private function setOrder($data, $order)
    {
        switch ($order) {
            case 'newest' :
                $data->orderBy('id', 'desc');
                break;
            case 'online' :
                $data->where('is_online', '1');
                break;
            case 'offline' :
                $data->where('is_online', '0');
                break;
            default :
                break;
        }
        return $data;
    }
}
