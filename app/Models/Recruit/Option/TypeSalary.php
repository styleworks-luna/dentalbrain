<?php

namespace App\Models\Recruit\Option;

use Illuminate\Database\Eloquent\Model;

class TypeSalary extends Model
{
    // 협의 후 결정
    static $TYPE_SALARY_1 = 1;
    // 내규에 따름
    static $TYPE_SALARY_2 = 2;
    // 연봉제
    static $TYPE_SALARY_3 = 3;
    // 기타
    static $TYPE_SALARY_4 = 4;

    public function recruitSalaries()
    {
        return $this->hasMany(RecruitApplication::class, 'type_salary_id', 'id');
    }
}
