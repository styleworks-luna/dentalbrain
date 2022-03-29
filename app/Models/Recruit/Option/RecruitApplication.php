<?php

namespace App\Models\Recruit\Option;

use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

class RecruitApplication extends Model
{
    public function recruit()
    {
        return $this->belongsTo(Recruit::class, 'recruit_id', 'id');
    }

    public function typeApplication()
    {
        return $this->belongsTo(TypeApplication::class, 'type_application_id', 'id');
    }
}
