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
    public function index(Request $request)
    {
        $data = Program::select('id','is_online','title','running_time')
        ->with([
            'ticket',
            'students' => function($query){
                $query->select('user_id','expired_at');
                $query->where('user_id',Auth::id());
            }
        ]);

        $data = $this->setOrder($data,$request->order);
        return view(viewPrefix() . 'pages.user.mypage.mypage_lecture');
    }


    private function setOrder($data, $order){
        switch($order){
            case 'newest' :
                $data->orderBy('id','desc');
                break;
            case 'online' :
                $data->where('is_online','1');
                break;
            case 'offline' :
                $data->where('is_online','0');
                break;
            default :
                break;
        }
        return $data;
    }
}
