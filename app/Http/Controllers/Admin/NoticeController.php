<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manage\Notice;
use App\Services\Search\NoticeSearchImpl;
use App\Services\Search\SearchService;
use App\Services\StatusChange\StatusChangeImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\SearchFunctions;

class NoticeController extends Controller
{
    use SearchFunctions;
    public function index()
    {
        $notice = Notice::whereNotNull('id')
            ->orderByDesc('id')
            ->paginate(10);
        return response()->json([
            'notice' => $notice,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'display_name' => 'required',
            'is_open' => ['required','boolean']
        ]);

        $validatedData['user_id'] = Auth()->id();
        Notice::create($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '추가되었습니다.',
        ]);
    }

    public function edit(Notice $notice)
    {
        return response()->json([
            'notice' => $notice,
        ]);
    }

    public function update(Notice $notice)
    {
        $v = Validator::make(request()->all(), [
            'title' => 'required',
            'content' => 'required',
            'is_open' => ['required','boolean']
        ]);

        $validatedData = $v->validate();

        $notice->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '변경이 완료되었습니다.',
        ]);
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();

        return response()->json([
            'success' => true,
            'msg' => '삭제가 완료되었습니다.',
        ]);
    }

    public function statusChange(Notice $notice)
    {
        $statusChangeImpl = new StatusChangeImpl();
        return $statusChangeImpl->statusChange($notice, 'is_open');
    }

    public function search(Request $request){
        $search = new SearchService(Notice::query());
        $this->addKeywordToSearchService($search,['title','content'],$request->keyword);
        $result = $search->search()->paginate('10');

        return response()->json(['search' =>$result]);
    }
}
