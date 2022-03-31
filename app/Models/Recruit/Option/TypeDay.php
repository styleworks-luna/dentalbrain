<?php

namespace App\Models\Recruit\Option;

use Illuminate\Database\Eloquent\Model;

class TypeDay extends Model
{
    // 월~금
    static $TYPE_DAY_1 = 1;
    // 월~토(격주)
    static $TYPE_DAY_2 = 2;
    // 월~토
    static $TYPE_DAY_3 = 3;
    // 기타
    static $TYPE_DAY_4 = 4;

    public function recruitDays(){
        return $this->hasMany(RecruitApplication::class, 'type_day_id', 'id');
    }
}
