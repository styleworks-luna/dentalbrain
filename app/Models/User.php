<?php

namespace App\Models;

use App\Models\Membership\Membership;
use App\Models\Program\Comment;
use App\Models\Program\LectureQuestion;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\SurveyAnswer;
use App\Models\Program\UserLike;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * // 6글자 이상, 대문자 혹은 소문자 | 숫자 포함된 패스워드여야 함.
     * @var string
     */
    static $passwordPattern = '/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/';
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
        'allow_email' => 'boolean',
        'is_paid' => 'boolean',
    ];
    protected $appends = [
        'need_license', 'job_name_id', 'job_name', 'license_num', 'has_membership'
    ];

    public function job()
    {
        return $this->belongsTo(UserJob::class, 'job_id', 'id');
    }

    public function isAdmin()
    {
        return $this->attributes['is_admin'] ? true : false;
    }

    public function likes()
    {
        return $this->hasMany(UserLike::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(ProgramStudent::class, 'user_id', 'id');
    }

    public function lectureQuestions()
    {
        return $this->hasMany(LectureQuestion::class, 'user_id', 'id');
    }

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'user_id', 'id');
    }

    public function scopeFindIdWithNameAndEmail($query, $name, $email)
    {
        return $query->where([
            'name' => $name,
            'email' => $email
        ])->first();
    }

    public function scopeFindIdWithNameAndPhone($query, $name, $phone)
    {
        return $query->where([
            'name' => $name,
            'phone' => $phone
        ])->first();
    }

    /**
     * @return Membership|null
     */
    public function recentMembership()
    {
        return $this->memberships()->whereNotNull('expired_at')
            ->orderByDesc('expired_at')->first();
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'user_id', 'id');
    }

    /**
     * @return Membership|null
     */
    public function availableMembership()
    {
        return $this->memberships()->where('expired_at', '>', now())
            ->orderByDesc('expired_at')->first();
    }

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

    protected function getHasMembershipAttribute(): bool
    {
        if ($this->memberships()->doesntExist()) {
            return false;
        }

        return $this->membership->isAvailable();
    }
}
