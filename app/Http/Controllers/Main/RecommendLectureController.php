<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Manage\Banner;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecommendLectureController extends Controller
{
    public function recommend(Request $request)
    {
        $request->validate([
            'category_id' => ['required', Rule::in([Banner::$POSITION_AREA3, Banner::$POSITION_AREA2])],
        ]);

        $banners = Banner::public()
            ->with(['program' => function (BelongsTo $query) {
                $query->with('thumbnail')->select('id', 'title', 'thumbnail_id', 'minor_category_id', 'running_time', 'price', 'discount_rate', 'discounted_price', 'term');
            }])->whereHas('program') // 프로그램이 있는 배너만
            ->where('category_id', '=', $request->category_id)
            ->select('id', 'program_id', 'category_id')
            ->orderByDesc('order')
            ->get();

        return response()->json([
            'banners' => $banners
        ]);
    }
}
