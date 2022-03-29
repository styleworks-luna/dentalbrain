<?php

namespace App\Models\Recruit\Option;

use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

class RecruitSalary extends Model
{
    public function recruit()
    {
        return $this->belongsTo(Recruit::class, 'recruit_id', 'id');
    }

    public function typeSalary()
    {
        return $this->belongsTo(TypeSalary::class, 'type_salary_id', 'id');
    }
}
