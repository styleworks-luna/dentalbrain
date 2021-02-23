<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LectureAnswer extends Model
{
    protected $table = 'lecture_answers';
    protected $guarded = [];

    public function question(){
        return $this->belongsTo(LectureQuestion::class, 'id2','id');
    }
}
