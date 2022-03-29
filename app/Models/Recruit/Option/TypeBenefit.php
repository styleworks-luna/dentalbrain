<?php

namespace App\Models\Recruit\Option;

use Illuminate\Database\Eloquent\Model;

class TypeBenefit extends Model
{
    public function recruitBenefits(){
        return $this->hasMany(RecruitBenefit::class, 'type_benefit_id', 'id');
    }
}
