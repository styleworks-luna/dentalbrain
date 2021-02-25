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
            ->with('lecture:id,title')
            ->orwhereHas('lecture',function($query) use($request){
                if($request->input('keyword')) {
                    $query->where('title', 'like', '%'.$request->input('keyword').'%');
                }
            });

        if(isset($request->is_answer)) $data->where('is_answer',$request->is_answer);

        $result = $data->orderBy('id','desc')->paginate(20);

        return $result;
    }
}
