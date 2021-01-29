<?php

namespace App\Models\Program\Survey;

use App\Models\Program\Program;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';
    protected $guarded = [];
    protected $appends = ['type'];

    public function parent()
    {
        return $this->belongsTo(Survey::class, 'parent_id', 'id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    /**
     * @see Survey::choices() 이거랑 똑같음.
     */
    public function children()
    {
        return $this->choices();
    }

    public function choices()
    {
        return $this->hasMany(Survey::class, 'parent_id', 'id');
    }

    public function getTypeAttribute()
    {
        return $this->category()->first()->eng_name ?? 'Need category_id';
    }

    public function category()
    {
        return $this->belongsTo(SurveyCategory::class, 'category_id', 'id');
    }

}
