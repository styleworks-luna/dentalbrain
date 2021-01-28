<?php

namespace App\Models\Program\Survey;

use Illuminate\Database\Eloquent\Model;

class SurveyCategory extends Model
{
    static $SINGLE_CHOICE = 1;
    static $MULTIPLE_CHOICE = 2;
    static $SHORT_ANSWER = 3;
    static $ADDRESS = 4;
    static $FILE = 5;

    protected $table = 'survey_categories';

    static function castStringTypeToId(string $categoryString)
    {
        return SurveyCategory::query()->where('eng_name', 'LIKE', $categoryString)
            ->first()->id;
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'category_id', 'id');
    }

}
