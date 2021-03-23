<?php

namespace App\Http\Controllers;

use App\Models\Manage\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()->orderBy('date', 'desc')->paginate(10);
        return view(viewPrefix() . 'pages.introduce.articles', [
            'articles' => $articles,
        ]);
    }
}
