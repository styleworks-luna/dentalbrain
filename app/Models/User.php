<?php

namespace App\Models;

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
        'need_license','job_name_id','job_name','license_num',
    ];

    public function getneedLicenseAttribute(){
        return  UserJobName::find($this->getJobNameIdAttribute())->need_license;
    }

    public function getJobNameIdAttribute(){
        return UserJob::find($this->attributes['job_id'])->job_name_id;
    }

    public function getJobNameAttribute(){
        return UserJobName::find($this->getJobNameIdAttribute())->name;
    }

    public function getLicenseNumAttribute(){
        return UserJob::find($this->attributes['job_id'])->license_num;
    }


    public function job()
    {
        return $this->belongsTo(UserJob::class, 'job_id','id');
    }

    public function isAdmin()
    {
        return $this->attributes['is_admin'] ? true : false;
    }
}
