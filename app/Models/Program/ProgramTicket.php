<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;

class ProgramTicket extends Model
{
    protected $table = 'program_tickets';

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(ProgramStudent::class, 'ticket_id', 'id');
    }
}
