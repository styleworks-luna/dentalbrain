<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;

class ProgramMinorCategory extends Model
{
    protected $table = 'program_minor_categories';

    public function programs()
    {
        return $this->hasMany('programs', 'minor_category_id', 'id');
    }
}
