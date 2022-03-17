<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Models\Manage\BannerTitle;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function show()
    {
        return response()->json([
            'banner_titles' => BannerTitle::all()
        ]);
    }

    public function update(Request $request, BannerTitle $bannerTitle)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:20']
        ]);

        $bannerTitle->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '타이틀 수정 완료',
        ]);
    }
}
