<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\LectureQuestion;
use App\Models\Program\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function index()
    {
       $data = LectureQuestion::query()->where('user_id',Auth::id())->with('lecture:id,title')->get()->toArray();
        return view(viewPrefix().'pages.user.mypage.mypage_question',['question' => $data]);
    }

    public function store(Request $request, Lecture $lecture){
        $validatedData = $request->validate([
            'question' => 'required|string'
        ]);
        DB::beginTransaction();
        try{
                $lectureQuestion = new LectureQuestion;
                $lectureQuestion->question = $validatedData['question'];
                $lectureQuestion->lecture_id = $lecture->id;
                $lectureQuestion->user_id = Auth::id();
                $lectureQuestion->save();
            DB::commit();
        }catch(\Exception $exception){
            DB::rollBack();
            Log::error('STORE QUESTION ERROR',[$exception]);
        }
    }
}
