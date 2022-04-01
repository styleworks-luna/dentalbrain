<?php

namespace App\Models\Recruit\Option;

use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

class TypeJob extends Model
{
    // 치과위생사
    static $TYPE_JOB_1 = 1;
    // 간호조무사
    static $TYPE_JOB_2 = 2;
    // 관리 및 경영지원
    static $TYPE_JOB_3 = 3;
    // 코디네이터/리셉션
    static $TYPE_JOB_4 = 4;
    // 무관
    static $TYPE_JOB_5 = 5;

    public function recruits()
    {
        return $this->hasMany(Recruit::class, 'type_job_id', 'id');
    }
}
