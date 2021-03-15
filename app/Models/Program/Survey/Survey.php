<?php

namespace App\Models\Program\Survey;

use App\Models\Program\Program;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @method static Builder result(int $programId)
 * @method static Builder resultWithUser(int $programId, int $userId)
 */
class Survey extends Model
{
    use SoftDeletes;

    protected $table = 'surveys';
    protected $guarded = [];
    protected $appends = ['type'];
    protected $casts = [
        'is_required' => 'boolean',
    ];

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

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_id', 'id');
    }

    public function answer()
    {
        return $this->hasOne(SurveyAnswer::class, 'survey_id', 'id');
    }

    public function scopeResult(Builder $query, $programId)
    {
        return $query->with(['choices',
            'answers' => function ($query) {
                $query->where('user_id', '=', Auth::id())->whereNull('deleted_at');
            }, 'answer' => function ($query) {
                $query->where('user_id', '=', Auth::id())->whereNull('deleted_at');
            }])
            ->where('program_id', '=', $programId)
            ->whereNull('parent_id')
            ->whereHas('answers', function ($query) {
                $query->where('user_id', '=', Auth::id());
            })->whereHas('answer', function ($query) {
                $query->where('user_id', '=', Auth::id());
            });
    }

    public function scopeResultWithUser(Builder $query, $programId, $userId)
    {
        return $query->with(['choices',
            'answers' => function ($query) use ($userId) {
                $query->where('user_id', '=', $userId);
            }, 'answers.file'])
            ->where('program_id', '=', $programId)
            ->whereNull('parent_id');
    }
}
