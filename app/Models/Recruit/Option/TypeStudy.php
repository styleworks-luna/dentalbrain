<?php

namespace App\Models\Recruit\Option;

use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

class TypeStudy extends Model
{
    public function recruits(){
        return $this->hasMany(Recruit::class, 'type_study_id', 'id');
    }
}
