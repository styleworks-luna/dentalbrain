<?php

namespace App\Models\Program\Survey;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survey extends Model
{
    protected $table = 'surveys';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(SurveyCategory::class, 'category_id', 'id');
    }

    public function parent()
    {
        return $this->hasMany(Survey::class, 'parent_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function choices()
    {
        return $this->children();
    }

    /**
     * @return BelongsTo
     * @see Survey::choices() 이거랑 똑같음.
     */
    public function children()
    {
        return $this->belongsTo(Survey::class, 'parent_id', 'id');
    }


}
