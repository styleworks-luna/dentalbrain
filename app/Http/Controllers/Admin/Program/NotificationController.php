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
   public function email(Program $program){
        $result = $program->students()
        ->orderByDesc('id')
        ->with(['user' => function($query){
            $query->select('id','name','login_id','allow_email');
            $query->where('allow_email',true);
        }])->get();
       return response()->json(['students'=> $result]);
   }
    public function sms(Program $program){
        $result = $program->students()
            ->orderByDesc('id')
            ->with(['user' => function($query){
                $query->select('id','name','login_id','allow_email');
            }])->get();
        return response()->json(['students'=> $result]);
    }

    public function sendEmail(Request $request){
        $validatedData = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'email' => 'required|array'
        ]);

        try{
            array_values(function ($value) use($validatedData){
                Mail::to($value)->send(new Lecture($validatedData['title'],$validatedData['message']));
            },$validatedData['email']);
            return response()->json(['success' => true]);
        }catch(\Exception $exception){
            Log::error('SEND LECTURE SMS ERROR',[$exception]);
            return response()->json(['success' => false, 'msg' => '에러가 발생하였습니다.']);
        }
    }

    public function sendSms(Request $request){
        $validatedData = $request->validate([
            'message' => 'required|string',
            'email' => 'required|array'
        ]);

        try{
            $ppurio = new Ppurio();
            array_values(function($value) use($validatedData, $ppurio){
                $ppurio->sendMessage($value,$validatedData['message']);
            },$validatedData['phone']);
            return response()->json(['success' => true]);
        }catch(\Exception $exception){
            Log::error('SEND LECTURE SMS ERROR',[$exception]);
            return response()->json(['success' => false, 'msg' => '에러가 발생하였습니다.']);
        }
    }
}