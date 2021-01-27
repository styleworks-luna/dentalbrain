<?php

namespace App\Models\Manage;

use App\Models\File;
use App\Services\ViewCount\ViewCountImpl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @method static Builder public ()
 */
class Banner extends Model
{
    use SoftDeletes;

    static $POSITION_TOP = 0;
    static $POSITION_BAR = 1;
    static $POSITION_RECOMMEND = 2;
    static $POSITION_BOTTOM = 3;

    protected $guarded = [];

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
            ->orderByDesc('order')
            ->with('desktopFile', 'mobileFile');
    }

    public function viewCountAdd(Banner $banner)
    {
        $viewCountAddImpl = new ViewCountImpl();
        $viewCountAddImpl->viewCountAdd($banner);
    }
}
