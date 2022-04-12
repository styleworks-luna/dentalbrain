<?php

namespace App\Models\Resume\Ability;

use Illuminate\Database\Eloquent\Model;

class AbilityCategory extends Model
{
    protected $table = 'ability_categories';

    protected $guarded = ['*'];

    public function abilities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ability::class, 'category_id', 'id');
    }
}
