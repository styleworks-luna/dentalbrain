<?php

namespace App\Models\Program;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LectureQuestion extends Model
{
    protected $table = 'lecture_questions';
    protected $guarded = [];
    protected $casts = ['is_answer' => 'boolean'];

    public function lecture(){
        return $this->belongsTo(Lecture::class,'lecture_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
