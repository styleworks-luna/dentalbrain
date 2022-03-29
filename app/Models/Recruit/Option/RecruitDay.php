<?php

namespace App\Models\Recruit\Option;

use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

class RecruitDay extends Model
{
    public function recruit()
    {
        return $this->belongsTo(Recruit::class, 'recruit_id', 'id');
    }

    public function typeDay()
    {
        return $this->belongsTo(TypeDay::class, 'type_day_id', 'id');
    }
}
