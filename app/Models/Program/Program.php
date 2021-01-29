<?php

namespace App\Models\Program;

use App\Models\File;
use App\Models\Program\Survey\Survey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;

    protected $table = 'programs';

    protected $appends = ['major_category_name', 'minor_category_name', 'user_like_cnt'];

    protected $guarded = [];

    protected $casts = [
        'is_online' => 'boolean',
        'is_open' => 'boolean',
    ];

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

    /*
     * ======= Define Appended Attributes =========
     */

    public function getMajorCategoryNameAttribute()
    {
        return ProgramMajorCategory::find($this->attributes['major_category_id'])->name;
    }

    public function getMinorCategoryNameAttribute()
    {
        return ProgramMinorCategory::find($this->attributes['minor_category_id'])->name;
    }

    public function getUserLikeCntAttribute()
    {
        return UserLike::query()->where('program_id', '=', $this->attributes['id'])->count();
    }
}
