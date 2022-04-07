<?php

namespace App\Models\Resume;

use App\Models\File;
use App\Models\Resume\Ability\AbilityAnswer;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Resume extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'resumes';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }

    public function abilityAnswers()
    {
        return $this->hasMany(AbilityAnswer::class, 'resume_id', 'id');
    }
}
