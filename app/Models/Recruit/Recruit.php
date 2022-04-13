<?php

namespace App\Models\Recruit;

use App\Models\File;
use App\Models\Payments\Payment;
use App\Models\Recruit\Option\RecruitApplication;
use App\Models\Recruit\Option\RecruitBenefit;
use App\Models\Recruit\Option\RecruitDay;
use App\Models\Recruit\Option\RecruitSalary;
use App\Models\Recruit\Option\TypeJob;
use App\Models\Recruit\Option\TypeStudy;
use App\Models\Recruit\Option\TypeWork;
use App\Payments\TossPayments\TossPaymentsResponse;
use Cron\FieldFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Xml\Facade;

class Recruit extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['ended_at'];

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

    const SESSION_KEY = 'recruit_create_data';


    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function recruitApplications()
    {
        return $this->hasMany(RecruitApplication::class, 'recruit_id', 'id');
    }

    public function recruitBenefits()
    {
        return $this->hasMany(RecruitBenefit::class, 'recruit_id', 'id');
    }

    public function recruitDays()
    {
        return $this->hasMany(RecruitDay::class, 'recruit_id', 'id');
    }

    public function recruitSalaries()
    {
        return $this->hasMany(RecruitSalary::class, 'recruit_id', 'id');
    }

    public function typeWork()
    {
        return $this->belongsTo(TypeWork::class, 'type_work_id', 'id');
    }

    public function typeJob()
    {
        return $this->belongsTo(TypeJob::class, 'type_job_id', 'id');
    }

    public function typeStudy()
    {
        return $this->belongsTo(TypeStudy::class, 'type_study_id', 'id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'main_file_id', 'id');
    }

    public function file1()
    {
        return $this->belongsTo(File::class, 'file_1_id', 'id');
    }

    public function file2()
    {
        return $this->belongsTo(File::class, 'file_2_id', 'id');
    }

    public function file3()
    {
        return $this->belongsTo(File::class, 'file_3_id', 'id');
    }
}
