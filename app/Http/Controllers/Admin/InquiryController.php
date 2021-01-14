<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-13
 * Time: 오전 10:32
 */

namespace App\Http\Controllers\Admin;
use App\Models\Manage\Inquiry;

class InquiryController {
    public function show(){
        $inquiry = Inquiry::whereNotNull('id')
            ->orderByDesc('id')
            ->paginate(20);
        return response()->json([
            'inquiry' => $inquiry,
        ]);
    }

    public function edit(Inquiry $inquiry){
        return response()->json([
           'inquiry' => $inquiry
        ]);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'title' => 'required',
            'content' => 'required',
        ]);
        $inquiry = Inquiry::find($request->id);
        $inquiry->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '수정되었습니다.',
        ]);
    }
    public function delete(Inquiry $inquiry){
        $inquiry->delete();

        return response()->json([
            'success' => true,
            'msg' => '삭제되었습니다.',
        ]);
    }
}