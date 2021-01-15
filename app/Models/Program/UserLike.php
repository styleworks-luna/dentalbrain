<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
    protected $table = 'user_likes';

    protected $guarded = [];

    public function program()
    {
        return $this->belongsTo('programs', 'program_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('users', 'user_id', 'id');
    }
}
