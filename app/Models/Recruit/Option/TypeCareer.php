<?php

namespace App\Models\Recruit\Option;

use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

class TypeCareer extends Model
{
    // 신입
    const TYPE_CAREER_1 = '1';
    // 1 ~ 9년
    const TYPE_CAREER_2 = '2';
    // 10 ~ 19년
    const TYPE_CAREER_3 = '3';
    // 20 ~ 29년
    const TYPE_CAREER_4 = '4';
    // 30년 이상
    const TYPE_CAREER_5 = '5';
    // 경력 무관
    const TYPE_CAREER_6 = '6';

    public function recruits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Recruit::class, 'type_career_id', 'id');
    }
}
