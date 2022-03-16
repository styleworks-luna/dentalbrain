<?php

namespace App\Models\Manage;

use App\Models\File;
use App\Models\Program\Program;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static Builder public ()
 */
class Banner extends Model
{
    use SoftDeletes;

    static $POSITION_TOP = 1;
    static $POSITION_BAR = 2;
    static $POSITION_RECOMMEND = 3;
    static $POSITION_BOTTOM = 4;
    static $POSITION_AREA2 = 5;
    static $POSITION_AREA3 = 6;

    protected $guarded = [];

    protected $appends = [
        'desktop_image_name', 'mobile_image_name', 'banner_category_name'
    ];

    public function getDesktopImageNameAttribute()
    {
        return File::find($this->desktop_file_id)->name;
    }

    public function getMobileImageNameAttribute()
    {
        return File::find($this->mobile_file_id)->name;
    }

    public function getBannerCategoryNameAttribute()
    {
        return BannerCategory::find($this->category_id)->name;
    }

    public function desktopFile()
    {
        return $this->belongsTo(File::class, 'desktop_file_id', 'id');
    }

    public function mobileFile()
    {
        return $this->belongsTo(File::class, 'mobile_file_id', 'id');
    }

    public function categories()
    {
        return $this->belongsTo(BannerCategory::class, 'category_id', 'id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopePublic($query)
    {
        return $query->where('is_open', '=', 1)
            ->where('started_at', '<=', now())
            ->where('ended_at', '>=', now())
            ->orderByDesc('order')
            ->inRandomOrder()
            ->with('desktopFile', 'mobileFile');
    }
}
