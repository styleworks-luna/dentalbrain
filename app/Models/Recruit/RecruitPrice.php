<?php

namespace App\Models\Recruit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RecruitPrice extends Model
{
    // hasMembership
    const HAS_NOT_MEMBERSHIP = 1;
    const HAS_MEMBERSHIP = 2;

    // 게재기간
    const TERM_DAY_7 = 7;
    const TERM_DAY_14 = 14;
    const TERM_DAY_21 = 21;

    // 게제기간 배수
    const TERM_FACTOR_1 = 1;
    const TERM_FACTOR_2 = 2;
    const TERM_FACTOR_3 = 3;

    public $timestamps = false;

    public static function getRecruitPrice($user)
    {
        if ($user->hasMembership) {
            $recruitPrice = RecruitPrice::query()->where('id', '=', RecruitPrice::HAS_MEMBERSHIP)->select('price')->first();
        } else {
            $recruitPrice = RecruitPrice::query()->where('id', '=', RecruitPrice::HAS_NOT_MEMBERSHIP)->select('price')->first();
        }
        return $recruitPrice->price;
    }

    public static function getTermPrice($price): array
    {
        return array(
            RecruitPrice::TERM_DAY_7 => $price * RecruitPrice::TERM_FACTOR_1,
            RecruitPrice::TERM_DAY_14 => $price * RecruitPrice::TERM_FACTOR_2,
            RecruitPrice::TERM_DAY_21 => $price * RecruitPrice::TERM_FACTOR_3 );
    }
}
