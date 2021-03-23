<?php

namespace App\Models\Manage;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    protected $casts = [
      'date' => 'datetime'
    ];

    public function thumbnail()
    {
        return $this->belongsTo(File::class, 'thumbnail_id', 'id');
    }
}
