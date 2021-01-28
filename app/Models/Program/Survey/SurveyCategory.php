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

    /**
     * 카테고리 eng_name 을 ID로 변환.
     *
     * @param string $categoryString
     * @return int survey_categories.id
     */
    static function castStringTypeToId(string $categoryString)
    {
        return SurveyCategory::query()->where('eng_name', 'LIKE', $categoryString)
            ->first()->id;
    }

    /**
     * 카테고리에 선택지가 필요한지 아닌지 체크함.
     * @param string|int $type 카테고리 ID OR 카테고리 eng_name OR 카테고리 name
     * @return bool
     */
    static function hasChoices($type)
    {
        if (is_string($type)) {
            $id = SurveyCategory::query()->where('eng_name', 'LIKE', $type)
                ->orWhere('name', 'LIKE', $type)
                ->first()->id;
        } else {
            $id = $type;
        }

        if ($id === SurveyCategory::$SINGLE_CHOICE
            || $id === SurveyCategory::$MULTIPLE_CHOICE) {
            return true;
        }

        return false;
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'category_id', 'id');
    }

}
