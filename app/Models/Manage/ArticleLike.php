<?php

namespace App\Models\Manage;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ArticleLike extends Model
{
    protected $table = 'article_likes';

    public function user()
    {
        $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function article()
    {
        $this->belongsTo(Article::class, 'article_id', 'id');
    }
}
