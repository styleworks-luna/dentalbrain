<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramTicket extends Model
{
    use SoftDeletes;

    protected $table = 'program_tickets';

    protected $guarded = [];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(ProgramStudent::class, 'ticket_id', 'id');
    }
}
