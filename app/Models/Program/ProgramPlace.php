<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;

class ProgramPlace extends Model
{
    protected $table = 'program_places';
    protected $guarded = [];
    protected $casts = [
        'started_at' => 'timestamp',
        'ended_at' => 'timestamp',
        'receipt_started_at' => 'timestamp',
        'receipt_ended_at' => 'timestamp',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
}
