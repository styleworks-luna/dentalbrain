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
            'ticket.program' => function($query) use ($request) {
                $query->select('id','thumbnail_id','title','is_online','running_time','major_category_id','minor_category_id')
                ->with('place:id,program_id,address,address_detail,sido,gugun,started_at,ended_at')
                ->with('thumbnail:id,path,url');
            },
        ])->whereHas('ticket.program',function($query) use($request) {
            $query = $this->addWhereOnlineOrOffline($request->order,$query);
        })->where('user_id','=',Auth::id());

        $data = $this->setNewest($data, $request->input('order'));
        
        return response()->json(['data'=> $data->paginate('10')]);
    }

    private function addWhereOnlineOrOffline($order,$query){
        if($order == 'online'){
            $query->where('is_online','1');
        }else if($order == 'offline'){
            $query->where('is_online','0');
        }
        return $query;
    }

    private function setNewest($data, $order)
    {
        if($order == 'newest'){
            $data->orderBy('id','desc');
        }
        return $data;
    }
}
