<?php

namespace App\Models\Program;

use App\Models\Program\LectureQuestion;
use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Lecture extends Model
{
    use SoftDeletes;

    protected $table = 'lectures';

    protected $guarded = [];

    /**
     * Youtube URL 로 부터 Youtube ID 값 얻어냅니다.
     * @param string $url Youtube URL
     * @return string|null Youtube ID
     * @deprecated
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

    /**
     * wecandeo URL 로 부터 wecandeo ID 값 얻어냅니다.
     * @param string $url wecandeo URL
     * @return string|null wecandeo ID
     * @deprecated
     */
    public static function getWecandeoIdFromUrl($url)
    {
        $regExp = /** @lang PhpRegExp */
            '/(?:play.wecandeo.com\/video\/v\/\?key=)(?<youtube>[0-9a-zA-Z-_]+)/';
        if (preg_match($regExp, $url, $matches)) {
            return $matches['youtube'];
        } else {
            return null;
        }
    }

    /**
     * URL으로부터 각각의 ID 값 추출함. (wecandeo, youtube)
     * @param ?string $url URL
     * @return string|null ID
     */
    public static function getVideoIdFromUrl(?string $url): ?string
    {
        if ($url == null) {
            return null;
        }
        $youtubeRegExp = '(?:youtube.[a-z]+\/[a-z?&]*v[\/|=]|youtu.be\/)([\d\w\-_]+)';
        $wecandeoRegExp = 'play.wecandeo.com\/video\/v\/\?key=([\d\w\-_]+)';
        $regExp = '/(?|' . $youtubeRegExp . '|' . $wecandeoRegExp . ')/';
        //$regExp = '/(?|(?:youtube.[a-z]+\/[a-z?&]*v[\/|=]|youtu.be\/)([\d\w\-_]+)|play.wecandeo.com\/video\/v\/\?key=([\d\w\-_]+))/';
        if (preg_match($regExp, $url, $matches)) {
            return $matches[1];
        } else {
            return null;
        }
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function thumbnail()
    {
        return $this->belongsTo(File::class, 'thumbnail_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(LectureQuestion::class, 'lecture_id', 'id');
    }
}
