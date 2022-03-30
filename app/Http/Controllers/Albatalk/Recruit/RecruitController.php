<?php

namespace App\Http\Controllers\Albatalk\Recruit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecruitController extends Controller
{
    public function payment()
    {
        return view('test');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_leader' => ['required', 'string', 'max:255'],
            'company_license' => ['required', 'string', 'max:255'],
            'company_phone' => ['required', 'numeric', 'digits_between:9,11'],

            'name' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'numeric', 'digits_between:9,11'],
            'email' => ['required', 'string', 'email' ,'max:255'],
            'url' => ['required', 'url'],
        ]);

        $validatedData['user_id'] = auth()->id();
        $validatedData['address'] = "서울 송파구 오금동";
        $validatedData['address_detail'] = "아남아파트";
        $validatedData['sido'] = "서울";
        $validatedData['gugun'] = "송파구";
        $validatedData['dong'] = "오금동";
        $validatedData['latitude'] = "37.50416961685561";
        $validatedData['longitude'] = "127.02096038259408";
        $validatedData['subway'] = "신논현 3번출구 도보 5분거리";
        $validatedData['career'] = "20";
        $validatedData['type_work_id'] = "1";
        $validatedData['type_job_id'] = "1";
        $validatedData['type_study_id'] = "1";
        $validatedData['started_at'] = "2022-03-29 15:32:32";
        $validatedData['ended_at'] = "2022-03-29 15:32:32";
        $validatedData['content'] = "안녕";

        return redirect()->route('albatalk.payment');
    }
}
