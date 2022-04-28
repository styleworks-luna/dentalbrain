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
use App\Services\Search\SearchService;
use Illuminate\Http\Request;

class InquiryController
{
    private $search;

    public function index(Request $request)
    {
        return response()->json([
            'inquiry' => $this->search($request),
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

    private function search(Request $request){
        $this->search = new SearchService(Inquiry::query());

        $this->addGubunCategory($request->gubun);

        $this->search
            ->addKeyword('title',$request->keyword)
            ->addKeyword('content',$request->keyword);

        $result = $this->search->search()->orderBy('id','desc')->paginate('20');

        return $result;
    }

    /**
     *
     * @param null|string $gubun
     */
    private function addGubunCategory($gubun){
        if(isset($gubun)){
            switch($gubun){
                case 'notCompleted':
                    $this->search->addCategory('is_answer','=',0);
                    break;
                case 'Completed':
                    $this->search->addCategory('is_answer','=',1);
                    break;
                case 'normal':
                    $this->search->addCategory('category_id','=',1);
                    break;
                case 'refund':
                    $this->search->addCategory('category_id','=',2);
                    break;
                case 'all':
                default:
                    break;
            }
        }
    }
}

