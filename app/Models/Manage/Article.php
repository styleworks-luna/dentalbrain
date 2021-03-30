<?php

namespace App\Models\Manage;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function thumbnail()
    {
        return $this->belongsTo(File::class, 'thumbnail_id', 'id');
    }
}
