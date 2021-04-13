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

    protected $appends = [
        'likes_count', 'category_name'
    ];


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

    public function getCategoryNameAttribute()
    {
        if ($this->category()) {
            return $this->category->name;
        } else {
            return null;
        }
    }

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id', 'id');
    }
}
