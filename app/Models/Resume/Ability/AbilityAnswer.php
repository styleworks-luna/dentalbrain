<?php

namespace App\Models\Resume\Ability;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property integer $id
 * @property Ability $ability
 * @property integer $ability_id
 * @property int $score
 * @property boolean $can_learn
 * @property string $content
 * @property DateTime created_at
 */
class AbilityAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'ability_answers';
    protected $guarded = [];
    protected $hidden = ['deleted_at', 'updated_at'];
    protected $casts = [
        'can_learn' => 'boolean',
    ];

    public function ability(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ability::class, 'ability_id', 'id');
    }
}
