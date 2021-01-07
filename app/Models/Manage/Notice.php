<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->attributes['display_name'] ?? '관리자';
    }


}
