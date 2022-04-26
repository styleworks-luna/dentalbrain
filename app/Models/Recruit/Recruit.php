<?php

namespace App\Models\Recruit;

use App\Models\File;
use App\Models\Payments\Payment;
use App\Models\Recruit\Option\RecruitApplication;
use App\Models\Recruit\Option\RecruitBenefit;
use App\Models\Recruit\Option\RecruitDay;
use App\Models\Recruit\Option\RecruitJob;
use App\Models\Recruit\Option\RecruitSalary;
use App\Models\Recruit\Option\TypeJob;
use App\Models\Recruit\Option\TypeStudy;
use App\Models\Recruit\Option\TypeWork;
use App\Models\Resume\AppliedResume;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruit extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['started_at', 'ended_at'];

    // 구인 노출 기간
    const TERM = 7;

    // 신입
    static $JUNIOR = 1;
    // 경력
    static $SENIOR = 2;

    // 학력
    static $ACADEMIC = 1;
    // 학력무관
    static $NO_ACADEMIC = 2;

    // 모집 마감 일
    static $DEADLINE_RECRUIT = 1;
    // 채용 시까지
    static $TIME_FOR_RECRUIT = 2;

    // 공개
    const IS_OPEN = 1;
    // 비공개
    const IS_NOT_OPEN = 0;

    // 구인 세션
    const SESSION_KEY = 'recruit_create_data';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function appliedResumes(): HasMany
    {
        return $this->hasMany(AppliedResume::class, 'recruit_id', 'id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function recruitApplications(): HasMany
    {
        return $this->hasMany(RecruitApplication::class, 'recruit_id', 'id');
    }

    public function recruitBenefits(): HasMany
    {
        return $this->hasMany(RecruitBenefit::class, 'recruit_id', 'id');
    }

    public function recruitJobs(): HasMany
    {
        return $this->hasMany(RecruitJob::class, 'recruit_id', 'id');
    }

    public function recruitDays(): HasMany
    {
        return $this->hasMany(RecruitDay::class, 'recruit_id', 'id');
    }

    public function recruitSalaries(): HasMany
    {
        return $this->hasMany(RecruitSalary::class, 'recruit_id', 'id');
    }

    public function typeWork(): BelongsTo
    {
        return $this->belongsTo(TypeWork::class, 'type_work_id', 'id');
    }

    public function typeJob(): BelongsTo
    {
        return $this->belongsTo(TypeJob::class, 'type_job_id', 'id');
    }

    public function typeStudy(): BelongsTo
    {
        return $this->belongsTo(TypeStudy::class, 'type_study_id', 'id');
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'main_file_id', 'id');
    }

    public function file1(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_1_id', 'id');
    }

    public function file2(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_2_id', 'id');
    }

    public function file3(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_3_id', 'id');
    }
}
