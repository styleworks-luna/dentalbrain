<?php

namespace App\Http\Controllers\Admin\Program;

use App\LectureQuestion;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
class QuestionController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'question' => $this->search($request),
        ]);
    }

    private function search(Request $request){
        $data  = LectureQuestion::query()
            ->where(function ($query) use($request){
                if($request->input('keyword')){
                    $query->where('question','like','%'.$request->input('keyword').'%');
                }
            })
            ->with('lecture:id,program_id','lecture.program:id,title','user:id,login_id,email')
            ->orwhereHas('lecture.program',function($query) use($request){
                if($request->input('keyword')) {
                    $query->where('title', 'like', '%'.$request->input('keyword').'%');
                }
            });

        if(isset($request->is_answer)) $data->where('is_answer',$request->is_answer);

        $result = $data->orderBy('id','desc')->paginate(20);

        return $result;
    }

    public function edit(LectureQuestion $question){
        $result = LectureQuestion::query()->where('id',$question->id)->
        with(['user:id,login_id,name,email,phone',
            'lecture'=>function($query){
                $query->select('id','program_id');
                $query->with('program:id,title');
            }])
            ->whereHas('lecture.program',function($query){
                $query->select('id','title');
            })
            ->get()
            ->toArray();
        return response()->json(['question' => $result]);
    }

    public function update(Request $request, LectureQuestion $question){
        $validatedData = $request->validate([
            'question' => 'required',
            'is_answer' => 'required|boolean'
        ]);

        if ($validatedData['is_answer'] == 1) {
            $validatedData['answered_at'] = now();
        }

        $question->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '수정되었습니다.',
        ]);
    }
}
