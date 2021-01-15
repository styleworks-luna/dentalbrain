<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;

class ProgramMajorCategory extends Model
{
    protected $table = 'program_major_categories';

    public function programs()
    {
        return $this->hasMany('programs', 'major_category_id', 'id');
    }
}
