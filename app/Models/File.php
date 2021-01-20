<?php

namespace App\Models;

use App\Models\Manage\Banner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class File extends Model
{
    use softDeletes;

    protected $guarded = [];

    protected $hidden = ['download_times'];

    public function desktopBanners()
    {
        return $this->hasMany(Banner::class, 'desktop_file_id', 'id');
    }

    public function mobileBanners()
    {
        return $this->hasMany(Banner::class, 'mobile_file_id', 'id');
    }
}
