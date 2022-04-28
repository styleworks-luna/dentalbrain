<?php

namespace App\Models\Recruit\Option;

use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, mixed $id)
 */
class RecruitJob extends Model
{
    protected $guarded = [];

    public function recruit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Recruit::class, 'recruit_id', 'id');
    }

    public function typeJob(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TypeJob::class, 'type_job_id', 'id');
    }
}
