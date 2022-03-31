<?php

namespace App\Models\Recruit\Option;

use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

class TypeWork extends Model
{

    // 정규직
    static $TYPE_WORK_1 = 1;
    // 계약직
    static $TYPE_WORK_2 = 2;
    // 아르바이트
    static $TYPE_WORK_3 = 3;

    public function recruits()
    {
        return $this->hasMany(Recruit::class, 'type_work_id', 'id');
    }
}
