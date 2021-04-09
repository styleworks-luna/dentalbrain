<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $attributes = [
        'likes_count',
    ];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id', 'id');
    }

    public function getLikesCountAttribute()
    {
        if ($this->likes()) {
            return $this->likes()->count();
        } else {
            return null;
        }
    }

    public function likes()
    {
        return $this->hasMany(ArticleLike::class, 'article_id', 'id');
    }
}
