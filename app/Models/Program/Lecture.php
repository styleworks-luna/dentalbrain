<?php

namespace App\Models\Program;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecture extends Model
{
    use SoftDeletes;

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
