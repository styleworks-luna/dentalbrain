<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramPlace extends Model
{
    use SoftDeletes;

    protected $table = 'program_places';
    protected $guarded = [];
    protected $casts = [
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
}
