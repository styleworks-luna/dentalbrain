<?php

namespace App\Models\Resume\Ability;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property integer $seq
 * @property string $type
 * @property Collection $answers
 */
class Ability extends Model
{
    protected $table = 'abilities';
    protected $guarded = ['*'];

    public function answers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AbilityAnswer::class, 'ability_id', 'id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AbilityCategory::class, 'category_id', 'id');
    }
}
