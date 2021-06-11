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
use App\Models\User;
use App\Services\Notification\Sms\Ppurio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function email(Program $program)
    {
        $result = User::query()->whereHas('students', function ($query) use ($program) {
            $query->where('program_id', '=', $program->id);
        })->where('allow_email', true)->get();

        return response()->json($result);
    }

    public function sms(Program $program)
    {
        $result = User::query()->whereHas('students', function ($query) use ($program) {
            $query->where('program_id', '=', $program->id);
        })->where('allow_sms', true)->get();

        return response()->json($result);
    }

    public function sendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'email' => 'required|array',
            'program_id' => 'required|numeric'
        ]);


        try {
            Mail::to('do-not-reply@dentalbrain.co.kr')
                ->bcc($validatedData['email'])->send(new Lecture($validatedData['title'], $validatedData['message'], $validatedData['program_id']));

            return response()->json(['success' => true, 'msg' => '이메일 발신되었습니다.'], 200);
        } catch (\Exception $exception) {
            Log::error('SEND LECTURE EMAIL ERROR', [$exception]);
            return response()->json(['success' => false, 'msg' => '에러가 발생하였습니다.'], 500);
        }
    }

    public function sendSms(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required|string',
            'phone' => 'required|array'
        ]);

        try {
            $ppurio = new Ppurio();
            foreach ($validatedData['phone'] as $phone) {
                $ppurio->sendMessage($phone, $validatedData['message']);
            }

            return response()->json(['success' => true, 'msg' => 'SMS 발신되었습니다.']);
        } catch (\Exception $exception) {
            Log::error('SEND LECTURE SMS ERROR', [$exception]);
            return response()->json(['success' => false, 'msg' => '에러가 발생하였습니다.'], 500);
        }
    }

    public function findIdWIthNameAndEmailInSendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        return User::FindIdWithNameAndEmail($validatedData['name'], $validatedData['email']);
    }

    public function findIdWithNameAndPhoneInSendSms(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);

        return User::FindIdWithNameAndPhone($validatedData['name'], $validatedData['phone']);
    }
}
