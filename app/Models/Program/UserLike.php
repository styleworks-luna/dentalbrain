<?php

namespace App\Models\Program;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserLike extends Pivot
{
    protected $table = 'user_likes';

    protected $guarded = [];

    public $incrementing = true;

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
