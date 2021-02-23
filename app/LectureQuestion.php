<?php

namespace App;

use App\Models\Program\Lecture;
use Illuminate\Database\Eloquent\Model;

class LectureQuestion extends Model
{
    protected $table = 'lecture_questions';
    protected $guarded = [];

    public function lecture(){
        return $this->belongsTo(Lecture::class,'lecture_id','id');
    }

    public function user(){
        return $this->belongsTo(Lecture::class,'user_id','id');
    }

    public function answer(){
        return $this->hasOne(LectureAnswer::class,'id2','id');
    }
}
