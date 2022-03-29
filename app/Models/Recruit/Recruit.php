<?php

namespace App\Models\Recruit;

use App\Models\Recruit\Option\RecruitApplication;
use App\Models\Recruit\Option\RecruitBenefit;
use App\Models\Recruit\Option\RecruitDay;
use App\Models\Recruit\Option\RecruitSalary;
use App\Models\Recruit\Option\TypeJob;
use App\Models\Recruit\Option\TypeStudy;
use App\Models\Recruit\Option\TypeWork;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruit extends Model
{
    use SoftDeletes;

    public function recruitApplications(){
        return $this->hasMany(RecruitApplication::class, 'recruit_id', 'id');
    }

    public function recruitBenefits(){
        return $this->hasMany(RecruitBenefit::class, 'recruit_id', 'id');
    }

    public function recruitDays(){
        return $this->hasMany(RecruitDay::class, 'recruit_id', 'id');
    }

    public function recruitSalaries(){
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


}
