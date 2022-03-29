<?php

namespace App\Models\Recruit\Option;

use Illuminate\Database\Eloquent\Model;

class TypeApplication extends Model
{
    public function recruitApplications(){
        return $this->hasMany(RecruitApplication::class, 'type_application_id', 'id');
    }
}
