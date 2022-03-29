<?php

namespace App\Models\Recruit\Option;

use Illuminate\Database\Eloquent\Model;

class TypeDay extends Model
{
    public function recruitDays(){
        return $this->hasMany(RecruitApplication::class, 'type_day_id', 'id');
    }
}
