<?php

namespace App\Models;

use App\Models\Program\ProgramStudent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'last_login_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'allow_email' => 'boolean'
    ];

    protected $appends = [
        'need_license', 'job_name_id', 'job_name', 'license_num',
    ];

    protected function getNeedLicenseAttribute()
    {
        $jobNameId = $this->getJobNameIdAttribute();
        if ($jobNameId !== null) {
            return UserJobName::find($jobNameId)->need_license;
        }
        return null;
    }

    protected function getJobNameIdAttribute()
    {
        if (isset($this->attributes['job_id'])) {
            return UserJob::find($this->attributes['job_id'])->job_name_id;
        }
        return null;
    }

    protected function getJobNameAttribute()
    {
        if ($this->getJobNameIdAttribute()) {
            return UserJobName::find($this->getJobNameIdAttribute())->name;
        }
        return null;
    }

    protected function getLicenseNumAttribute()
    {
        if (isset($this->attributes['job_id'])) {
            return UserJob::find($this->attributes['job_id'])->license_num;
        }
        return null;
    }


    public function job()
    {
        return $this->belongsTo(UserJob::class, 'job_id', 'id');
    }

    public function isAdmin()
    {
        return $this->attributes['is_admin'] ? true : false;
    }

    public function students()
    {
        return $this->hasOne(ProgramStudent::class, 'user_id', 'id');
    }
}
