<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserJob extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function jobName()
    {
        return $this->belongsTo(UserJobName::class, 'job_name_id');
    }
}
