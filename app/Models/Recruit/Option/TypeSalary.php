<?php

namespace App\Models\Recruit\Option;

use Illuminate\Database\Eloquent\Model;

class TypeSalary extends Model
{
    public function recruitSalaries(){
        return $this->hasMany(RecruitApplication::class, 'type_salary_id', 'id');
    }
}
