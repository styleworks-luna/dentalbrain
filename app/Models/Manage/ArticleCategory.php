<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    static $CONSULTANT = 1;
    static $SPECIAL = 2;
    static $REVIEW = 3;

    protected $table = 'article_categories';

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id', 'id');
    }
}
