<?php

namespace App\Models\Program;

use App\Models\File;
use App\Models\Program\Survey\Survey;
use App\Models\Program\Survey\SurveyAnswer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @method static Builder main ()
 * @method static Builder public (string|int|null $category = null, string|null $orderBy = 'newest')
 */
class Program extends Model
{
    use SoftDeletes;

    protected $table = 'programs';

    protected $appends = ['major_category_name', 'minor_category_name', 'user_like_cnt', 'auth_like'];

    protected $guarded = [];

    protected $casts = [
        'is_online' => 'boolean',
        'is_open' => 'boolean',
    ];

    /*
     * ======= Custom Functions =========
     */

    /**
     * 이미 유저가 강의를 지불했는지 확인.
     * @return bool
     */
    public function alreadyPaid()
    {
        $user = Auth::user();
        if ($user != null) {
            return $user->students()
                ->where('ticket_id', '=', $this->ticket->id)
                ->where(function ($query) {
                    $query->whereNotNull('expired_at')
                        ->orWhere('expired_at', '>', now());
                })->exists();
        } else {
            return false;
        }
    }

    /*
     * ======= Define Relationships =========
     */

    public function majorCategory()
    {
        return $this->belongsTo(ProgramMajorCategory::class, 'major_category_id');
    }

    public function minorCategory()
    {
        return $this->belongsTo(ProgramMinorCategory::class, 'minor_category_id');
    }

    public function tickets()
    {
        return $this->hasMany(ProgramTicket::class, 'program_id', 'id');
    }


    public function ticket()
    {
        return $this->hasOne(ProgramTicket::class, 'program_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'program_id', 'id');
    }

    public function students()
    {
        return $this->hasManyThrough(ProgramStudent::class, ProgramTicket::class,
            'program_id', 'ticket_id',
            'id', 'id');
    }

    public function thumbnail()
    {
        return $this->belongsTo(File::class, 'thumbnail_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo(File::class, 'material_id', 'id');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'program_id', 'id');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class, 'program_id', 'id');
    }

    public function place()
    {
        return $this->hasOne(ProgramPlace::class, 'program_id', 'id');
    }

    public function like()
    {
        return $this->hasMany(UserLike::class, 'program_id', 'id')
            ->where('user_id', '=', Auth::id());
    }

    public function answers()
    {
        return $this->hasManyThrough(SurveyAnswer::class, Survey::class,
            'program_id', 'survey_id',
            'id', 'id');
    }


    /*
     * ======= Define Appended Attributes =========
     */

    public function getMajorCategoryNameAttribute()
    {
        if (isset($this->attributes['major_category_id']))
            return ProgramMajorCategory::find($this->attributes['major_category_id'])->name;
        else
            return null;
    }

    public function getMinorCategoryNameAttribute()
    {
        if (isset($this->attributes['minor_category_id']))
            return ProgramMinorCategory::find($this->attributes['minor_category_id'])->name;
        else
            return null;
    }

    public function getUserLikeCntAttribute()
    {
        return UserLike::query()->where('program_id', '=', $this->attributes['id'])->count();
    }

    public function getAuthLikeAttribute()
    {
        if (Auth::guest()) {
            return false;
        } else {
            return UserLike::query()
                ->where('program_id', '=', $this->attributes['id'])
                ->where('user_id', '=', Auth::id())->exists();
        }

    }

    /*
     * ============== Scope ==============
     */
    public function scopeMain(Builder $query)
    {
        return $query->select(['id', 'thumbnail_id'])
            ->where('is_open', '=', 1)
            ->with('thumbnail:id,url')->orderByDesc('created_at');
    }

    public function scopePublic(Builder $query, $category, $orderBy)
    {
        $programs = $query->select(['id', 'thumbnail_id', 'major_category_id', 'minor_category_id', 'title', 'running_time'])
            ->where('is_open', '=', 1)
            ->with(['thumbnail:id,url', 'ticket:id,price,program_id,is_free'])
            ->withCount('students');

        if ($category !== null) {
            $programs = $programs->where('major_category_id', '=', $category);
        }

        if ($orderBy == 'popular') {
            $programs = $programs->orderByDesc('students_count');

        } else {
            $programs = $programs->orderByDesc('created_at');
        }

        return $programs;
    }
}
