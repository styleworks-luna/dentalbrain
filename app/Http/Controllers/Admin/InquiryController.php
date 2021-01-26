<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-13
 * Time: 오전 10:32
 */

namespace App\Http\Controllers\Admin;

use App\Models\Manage\Inquiry;
use App\Models\Manage\InquiryCategory;
use App\Services\Search\SearchImpl;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use App\Traits\SearchFunctions;

class InquiryController
{
    use SearchFunctions;
    public function index()
    {
        $inquiry = Inquiry::whereNotNull('id')
            ->orderByDesc('id')
            ->paginate(20);
        return response()->json([
            'inquiry' => $inquiry,
        ]);
    }

    public function edit(Inquiry $inquiry)
    {
        return response()->json([
            'inquiry' => $inquiry
        ]);
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|numeric',
            'is_answer' => 'required|boolean'
        ]);
        if ($validatedData['is_answer'] == 1) {
            $validatedData['answered_at'] = now();
        }
        $inquiry->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '수정되었습니다.',
        ]);
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return response()->json([
            'success' => true,
            'msg' => '삭제되었습니다.',
        ]);
    }

    public function getInquiryCategory()
    {
        return response()->json(
            ['category' => InquiryCategory::all()]
        );
    }

    public function search(Request $request){
        $search = new SearchService(Inquiry::query());
        $gubun = $this->returnArrayGubun($request->gubun);

        $this->addKeywordToSearchService($search,['title','content'],$request->keyword);
        $this->addCategoryToSearchService($search,$gubun);
        $result = $search->search()->paginate('10');

        return response()->json(
            ['search' => $result]
        );
    }

    public function returnArrayGubun(string $gubun){
        if(isset($gubun)){
            switch($gubun){
                case 'notCompleted':
                    return ['is_answer','=',0];
                case 'Completed':
                    return ['is_answer','=',1];
                case 'normal':
                    return ['category_id','=',1];
                case 'refund':
                    return ['category_id','=',2];
                default:
                case 'all':
                    return null;
            }
        }else{
            return null;
        }
    }
}

