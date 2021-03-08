<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramTicket extends Model
{
    use SoftDeletes;

    protected $table = 'program_tickets';

    protected $guarded = [];

    protected $appends = [
        'repeat_price'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_free' => 'boolean'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(ProgramStudent::class, 'ticket_id', 'id');
    }

    public function getRepeatPriceAttribute()
    {
        return $this->attributes['price'] * 7 / 10 ;
    }
}
