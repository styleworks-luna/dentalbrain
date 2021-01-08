<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    protected $hidden = ['download_times'];

    public function banner()
    {
        return $this->hasOne('banner', 'file_id', 'id');
    }
}
