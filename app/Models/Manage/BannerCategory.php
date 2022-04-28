<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class BannerCategory extends Model
{
    protected $table = 'banner_categories';

    public function banner(){
        return $this->hasMany(Banner::class,'position','id');
    }
}
