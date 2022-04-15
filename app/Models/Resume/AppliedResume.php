<?php

namespace App\Models\Resume;

use App\Models\Recruit\Recruit;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppliedResume extends Model
{
    use SoftDeletes;

    protected $table = 'applied_resumes';
    protected $guarded = [];

    protected $dates = ['applied_at', 'canceled_at'];

    const STATUS_SUCCESS = 1;
    const STATUS_CANCELED = 2;

    public function recruit(): BelongsTo
    {
        return $this->belongsTo(Recruit::class, 'recruit_id', 'id');
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class, 'resume_id', 'id');
    }
}
