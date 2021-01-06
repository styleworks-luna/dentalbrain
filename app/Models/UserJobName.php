<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJobName extends Model
{
    public function jobs()
    {
        return $this->hasMany(UserJob::class, 'job_name_id');
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, UserJob::class, 'job_name_id', 'job_id');
    }
}
