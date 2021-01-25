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
        $query = Inquiry::search($request->keyword);
        switch($request->gubun){
            case 'notCompleted':
                $query->where('is_answer',0);
                break;
            case 'completed':
                $query->where('is_answer',1);
                break;
            case 'normal':
                $query->where('category_id',1);
                break;
            case 'default':
                $query->where('category_id',2);
                break;
            case 'all':
            default:
                break;
        }
        return response()->json(
            ['search' => $query->get()]
        );
    }
}

