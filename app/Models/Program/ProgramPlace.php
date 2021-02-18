<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;

class ProgramPlace extends Model
{
    protected $table = 'program_places';
    protected $guarded = [];
    protected $casts = [];
    protected $appends = ['korean_time', 'full_address'];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function getKoreanTimeAttribute()
    {
        if (isset($this->attributes['started_at']) && isset($this->attributes['ended_at'])) {
            $started_at = date('Y', strtotime($this->attributes['started_at'])) . '년 ' . date('m', strtotime($this->attributes['started_at'])) . '월 ' . date('d', strtotime($this->attributes['started_at'])) . '일 ' . '(' . carbonDate($this->attributes['started_at'], 'ddd') . ') ' . date('H:i', strtotime($this->attributes['started_at']));
            $tilde = ' ~ ';
            $ended_at = date('Y', strtotime($this->attributes['ended_at'])) . '년 ' . date('m', strtotime($this->attributes['ended_at'])) . '월 ' . date('d', strtotime($this->attributes['ended_at'])) . '일 ' . '(' . carbonDate($this->attributes['ended_at'], 'ddd') . ') ' . date('H:i', strtotime($this->attributes['ended_at']));
            return $started_at . $tilde . $ended_at;
        }
        return null;
    }

    public function getFullAddressAttribute()
    {
        if (isset($this->attributes['address']) && isset($this->attributes['address_detail'])) {
            return $this->attributes['address'] . ' ' . $this->attributes['address_detail'];
        }
        return null;
    }
}
