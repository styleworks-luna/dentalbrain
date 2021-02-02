<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;

class ProgramPlace extends Model
{
    protected $table = 'program_places';
    protected $guarded = [];
    protected $casts = [];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
}
