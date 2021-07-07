<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProgramMajorCategory extends Model
{
    protected $table = 'program_major_categories';

    /**
     * @return Collection
     */
    public static function getNavigation()
    {
        return ProgramMajorCategory::query()->orderBy('id')
            ->where('id', '!=', 8)
            ->select(['id', 'name'])->get()->prepend(['id' => '0', 'name' => '전체']);
    }

    public function programs()
    {
        return $this->hasMany('programs', 'major_category_id', 'id');
    }
}
