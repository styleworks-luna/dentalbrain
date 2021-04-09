<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $table = 'article_categories';

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id', 'id');
    }
}
