<?php

namespace App\Models\Program;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function parent()
    {
        $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

    public function children()
    {
        $this->hasMany(Comment::class, 'parent_id', 'id');
    }
}
