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
use App\Services\Search\InquirySearchImpl;
use App\Services\Search\SearchImpl;
use Illuminate\Http\Request;

class InquiryController
{
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
        $inquiry = new Inquiry();
        $inquirySearch = new InquirySearchImpl($inquiry);
        $inquirySearch->setSearchKeyword($request->keyword);
        $inquirySearch->setGubun($request->gubun);


        return response()->json(
            ['search' => $inquirySearch->search()]
        );
    }
}

