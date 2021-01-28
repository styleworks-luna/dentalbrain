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
    protected $guarded = [];

    /**
     * Youtube URL 로 부터 Youtube ID 값 얻어냅니다.
     * @param string $url Youtube URL
     * @return string|null Youtube ID
     */
    public static function getYoutubeIdFromUrl(string $url)
    {
        $regExp = /** @lang PhpRegExp */
            '/(?:youtube.[a-z]+\/[a-z?&]*v[\/|=]|youtu.be\/)(?<youtube>[0-9a-zA-Z-_]+)/';
        if (preg_match($regExp, $url, $matches)) {
            return $matches['youtube'];
        } else {
            return null;
        }
    }

    public function program()
    {
        return $this->belongsTo('programs', 'program_id', 'id');
    }

    public function thumbnail()
    {
        return $this->belongsTo(File::class, 'thumbnail_id', 'id');
    }

    public function getThumbnailUrlAttribute()
    {
        return File::find($this->attributes['thumbnail_id'])->url;
    }
}
