<?php

namespace App\Models\Program;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LectureProgress extends Model
{
    protected $table = 'lecture_progress';
    protected $guarded = [];
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
