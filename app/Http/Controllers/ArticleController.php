<?php

namespace App\Http\Controllers;

use App\Models\Manage\Article;
use App\Models\Manage\ArticleCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index()
    {
        return view(viewPrefix() . 'pages.introduce.community');
    }

    public function articles(Request $request)
    {
        $v = Validator::make($request->all(), [
            'category' => ['nullable', Rule::exists('article_categories', 'id')],
            'sort' => ['required', Rule::in('popular', 'newest')],
        ]);

        $v->validate();

        $category = $request->get('category');

        $articles = Article::query();
        if ($category != null) {
            $articles->whereHas('category', function (Builder $query) use ($category) {
                $query->where('id', '=', $category);
            });
        }
        if ($request->get('sort') == 'newest') {
            $articles->orderBy('date', 'desc');
        } else {
            $articles->orderBy('views', 'desc');
        }


        return response()->json($articles->paginate(20));
    }

    public function categories()
    {
        return response()->json(ArticleCategory::all());
    }
}
