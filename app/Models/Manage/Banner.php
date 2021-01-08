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

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopePublic($query)
    {
        return $query->where('is_active', '=', 1)
            ->where('started_at', '<=', now())
            ->where('ended_at', '>=', now())
            ->with('file');
    }
}
