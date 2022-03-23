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

        $special_pattern = "/[#\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i";

        if (preg_match($special_pattern, $validatedData['title'])){
            return response()->json([
                'success' => false,
                'msg' => '특수 문자는 사용할 수 없습니다.',
            ]);
        }

        $bannerTitle->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '타이틀 수정 완료',
        ]);
    }
}
