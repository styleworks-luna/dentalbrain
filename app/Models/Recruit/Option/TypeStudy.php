<?php

namespace App\Models\Recruit\Option;

use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

class TypeStudy extends Model
{

    // 고등학교 졸업
    static $TYPE_STUDY_1 = '1';
    // 전문대학 1년 재중
    static $TYPE_STUDY_2 = '2';
    // 전문대학 2년 재중
    static $TYPE_STUDY_3 = '3';
    // 전문대학 3년 재중
    static $TYPE_STUDY_4 = '4';
    // 전문대학 졸업
    static $TYPE_STUDY_5 = '5';
    // 대학교 1년 재중
    static $TYPE_STUDY_6 = '6';
    // 대학교 2년 재중
    static $TYPE_STUDY_7 = '7';
    // 대학교 3년 재중
    static $TYPE_STUDY_8 = '8';
    // 대학교 4년 재중
    static $TYPE_STUDY_9 = '9';
    // 대학교 졸업(학사)
    static $TYPE_STUDY_10 = '10';
    // 대학원 재중
    static $TYPE_STUDY_11 = '11';
    // 대학원 졸업(석사)
    static $TYPE_STUDY_12 = '12';
    // 대학원 졸업(박사)
    static $TYPE_STUDY_13 = '13';

    public function recruits()
    {
        return $this->hasMany(Recruit::class, 'type_study_id', 'id');
    }
}
