<?php

namespace App\Models\Recruit;

use Illuminate\Database\Eloquent\Model;

class RecruitPrice extends Model
{
    // hasMembership
    const HAS_NOT_MEMBERSHIP = 1;
    const HAS_MEMBERSHIP = 2;

    public $timestamps = false;

    public static function getRecruitPrice($user)
    {
        if ($user->hasMembership) {
            $recruitPrice = RecruitPrice::query()->where('id', '=', RecruitPrice::HAS_MEMBERSHIP)->select('price')->first();
            return $recruitPrice->price;
        } else {
            $recruitPrice = RecruitPrice::query()->where('id', '=', RecruitPrice::HAS_NOT_MEMBERSHIP)->select('price')->first();
            return $recruitPrice->price;
        }
    }
}
