<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'programs';

    protected $appends = ['major_category_name', 'minor_category_name'];

    public function majorCategory()
    {
        return $this->belongsTo('program_major_categories', 'major_category_id');
    }

    public function minorCategory()
    {
        return $this->belongsTo('program_minor_categories', 'minor_category_id');
    }

    public function getMajorCategoryNameAttribute()
    {
        return ProgramMajorCategory::find($this->attributes['major_category_id'])->name;
    }

    public function getMinorCategoryNameAttribute()
    {
        return ProgramMinorCategory::find($this->attributes['minor_category_id'])->name;
    }
}
