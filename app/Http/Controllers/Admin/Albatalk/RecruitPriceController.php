<?php

namespace App\Http\Controllers\Admin\Albatalk;

use App\Http\Controllers\Controller;
use App\Models\Recruit\RecruitPrice;
use Illuminate\Http\Request;

class RecruitPriceController extends Controller
{
    public function index()
    {
        $recruitPrices = RecruitPrice::query()->get(['id', 'price'])->mapWithKeys(function ($item, $key) {
            return [$item['id'] => $item['price']];
        });

        return response()->json([
            'msg' => '변경되었습니다.',
            'price' => $recruitPrices[RecruitPrice::HAS_NOT_MEMBERSHIP],
            'membership_price' => $recruitPrices[RecruitPrice::HAS_MEMBERSHIP],
        ]);
    }

    public function updateNormal(Request $request)
    {
        $request->validate([
            'price' => ['required', 'numeric']
        ]);

        $price = $request->get('price');
        RecruitPrice::query()->where('id', '=', RecruitPrice::HAS_NOT_MEMBERSHIP)->update([
            'price' => $price
        ]);

        return response()->json([
            'msg' => '변경되었습니다.'
        ]);
    }

    public function updateMembership(Request $request)
    {
        $request->validate([
            'price' => ['required', 'numeric', 'min:500']
        ]);

        $price = $request->get('price');
        RecruitPrice::query()->where('id', '=', RecruitPrice::HAS_MEMBERSHIP)->update([
            'price' => $price
        ]);

        return response()->json([
            'msg' => '변경되었습니다.'
        ]);
    }
}
