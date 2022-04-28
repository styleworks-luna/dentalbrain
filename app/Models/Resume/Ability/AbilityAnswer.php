<?php

namespace App\Models\Resume\Ability;

use App\Models\Resume\Resume;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property integer $id
 * @property Ability $ability
 * @property integer $ability_id
 * @property int $score
 * @property boolean $can_learn
 * @property string $content
 * @property DateTime created_at
 * @method  static Builder onResume($resume) :
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

    public function ability(): BelongsTo
    {
        return $this->belongsTo(Ability::class, 'ability_id', 'id');
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class, 'resume_id', 'id');
    }

    public function scopeOnResume(Builder $query, $resume): Builder
    {
        return $query
            ->with('ability')
            ->where('resume_id', '=', $resume->id);
    }
}
