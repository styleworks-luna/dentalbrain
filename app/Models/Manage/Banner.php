<?php

namespace App\Models\Manage;

use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder public ()
 */
class Banner extends Model
{
    static $POSITION_MIDDLE = 0;
    static $POSITION_BOTTOM = 1;

    protected $guarded = [];

    protected $hidden = ['clicks', 'is_active', 'started_at', 'ended_at', 'position'];

    protected $appends = [
        'desktop_image_name', 'mobile_image_name'
    ];

    public function getDesktopImageNameAttribute()
    {
        return File::find($this->desktop_file_id)->name;
    }

    public function getMobileImageNameAttribute()
    {
        return File::find($this->mobile_file_id)->name;
    }

    public function desktopFile()
    {
        return $this->belongsTo(File::class, 'desktop_file_id', 'id');
    }

    public function mobileFile()
    {
        return $this->belongsTo(File::class, 'mobile_file_id', 'id');
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
            ->with('file');
    }
}
