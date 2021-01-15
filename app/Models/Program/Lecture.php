<?php

namespace App\Models\Program;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lecture extends Model
{
    protected $table = 'lectures';

    protected $appends = ['thumbnail_url'];

    public function program()
    {
        return $this->belongsTo('programs', 'program_id', 'id');
    }

    public function thumbnail()
    {
        return $this->belongsTo('files', 'thumbnail_id', 'id');
    }

    public function getThumbnailUrlAttribute()
    {
        return File::find($this->attributes['thumbnail_id'])->url;
    }
}
