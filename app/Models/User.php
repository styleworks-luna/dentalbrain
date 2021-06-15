<?php

namespace App\Models;

use App\Models\Membership\Membership;
use App\Models\Program\Comment;
use App\Models\Program\LectureQuestion;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\SurveyAnswer;
use App\Models\Program\UserLike;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed membership_started_at
 * @property mixed membership_expired_at
 */
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /*  ==============================================================================
     *  Attributes
     *  ==============================================================================
     */

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
    ];
    protected $appends = [
        'need_license', 'job_name_id', 'job_name', 'license_num', 'has_membership'
    ];

    /*  ==============================================================================
     *  Relations
     *  ==============================================================================
     */

    public function job()
    {
        return $this->belongsTo(UserJob::class, 'job_id', 'id');
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

    public function likePrograms()
    {
        return $this->belongsToMany(Program::class, 'user_likes')
            ->using(UserLike::class);
    }

    /*  ==============================================================================
     *  Repositories
     *  ==============================================================================
     */

    public function updateWhenMembershipCancel(Membership $membership): bool
    {
        $newMembershipExpiredAt = Carbon::parse($this->membership_expired_at)->subDays($membership->applied_days);

        if ($this->membership_started_at > $newMembershipExpiredAt) {
            return $this->update([
                'membership_started_at' => $newMembershipExpiredAt,
                'membership_expired_at' => $newMembershipExpiredAt,
            ]);
        } else {
            return $this->update([
                'membership_expired_at' => $newMembershipExpiredAt,
            ]);
        }
    }

    public function updateWhenMembershipPaid($days): bool
    {
        if ($this->isPaid()) {
            return $this->update([
                'membership_expired_at' => Carbon::parse($this->membership_expired_at)->addDays($days),
            ]);
        } else {
            return $this->update([
                'membership_started_at' => now(),
                'membership_expired_at' => now()->addDays($days),
            ]);
        }
    }

    /*  ==============================================================================
     *  Functions
     *  ==============================================================================
     */

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        if ($this->membership_expired_at == null || $this->membership_started_at == null) {
            return false;
        }
        return $this->membership_expired_at > now() && $this->membership_started_at < now();
    }

    public function isAdmin()
    {
        return (bool)$this->is_admin;
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

    public function getMembershipStartedAt()
    {
        $membership = $this->availableEarliestMembership();
        if ($membership) {
            return $membership->started_at;
        }
        return null;
    }

    /**
     * @return Membership|null
     */
    public function availableEarliestMembership()
    {
        $memberships = $this->availableMemberships();
        if (!$memberships) {
            return null;
        }
        return $memberships->last();
    }

    /**
     * Order By 'expired_at' DESC
     * @return Collection
     */
    public function availableMemberships()
    {
        return $this->availableMembershipsBuilder()->get();
    }

    /**
     * @return Builder
     */
    public function availableMembershipsBuilder()
    {
        // Membership@scopeAvailable()
        return $this->memberships()->available()->orderByDesc('expired_at');
    }

    public function getMembershipExpiredAt()
    {
        $membership = $this->availableLatestMembership();
        if ($membership) {
            return $membership->expired_at;
        }
        return null;
    }

    /**
     * @return Membership|null
     */
    public function availableLatestMembership()
    {
        $memberships = $this->availableMemberships();
        if (!$memberships) {
            return null;
        }
        return $memberships->first();
    }

    /*  ==============================================================================
     *  Scopes
     *  ==============================================================================
     */

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
     * @param Builder $query
     * @return Builder
     */
    public function scopePaid($query)
    {
        return $query->where('membership_started_at', '<', now())->where('membership_expired_at', '>', now());
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeDoesntPaid($query)
    {
        return $query->whereNull('membership_started_at')->orWhereNull('membership_expired_at')
            ->orWhere('membership_expired_at', '<', now());
    }

    /*  ==============================================================================
     *  Append & Casting
     *  ==============================================================================
     */

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
        return $this->isPaid();
    }


}
