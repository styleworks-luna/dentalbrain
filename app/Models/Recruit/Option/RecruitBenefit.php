<?php

namespace App\Models\Recruit\Option;

use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

class RecruitBenefit extends Model
{
    public function recruit()
    {
        return $this->belongsTo(Recruit::class, 'recruit_id', 'id');
    }

    public function typeBenefit()
    {
        return $this->belongsTo(TypeBenefit::class, 'type_benefit_id', 'id');
    }
}
