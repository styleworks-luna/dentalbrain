<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-03-03
 * Time: 오후 1:37
 */
namespace App\Http\Controllers\Admin\Program;

use App\Http\Controllers\Controller;
use App\Mail\Lecture;
use App\Models\Program\Program;
use App\Services\Notification\Sms\Ppurio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller{
   public function index(Program $program){
        $result = $program->students()
        ->orderByDesc('id')
        ->with(['ticket', 'payment' => function ($query) {
            $query->select('id');
        }, 'user' => function($query){
            $query->select('id','login_id','allow_email');
            $query->where('allow_email',true);
        }])->get();
       return response()->json(['students'=> $result]);
   }

    public function sendEmail(Request $request){
        try{
            array_values(function ($value) use($request){
                Mail::to($value)->send(new Lecture($request->title,$request->message));
            },$request->email);
            return response()->json(['success' => true]);
        }catch(\Exception $exception){
            Log::error('SEND LECTURE SMS ERROR',[$exception]);
            return response()->json(['success' => false, 'msg' => '에러가 발생하였습니다.']);
        }
    }

    public function sendSms(Request $request){
        try{
            $ppurio = new Ppurio();
            array_values(function($value) use($request, $ppurio){
                $ppurio->sendMessage($value,$request->message);
            },$request->phone);
            return response()->json(['success' => true]);
        }catch(\Exception $exception){
            Log::error('SEND LECTURE SMS ERROR',[$exception]);
            return response()->json(['success' => false, 'msg' => '에러가 발생하였습니다.']);
        }
    }
}