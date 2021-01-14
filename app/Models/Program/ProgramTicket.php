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
}
