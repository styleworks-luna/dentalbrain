<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class File extends Model
{
    use softDeletes;
    protected $guarded = [];

    protected $hidden = ['download_times'];

    public function banner()
    {
        return $this->hasOne('banner', 'file_id', 'id');
    }
}
