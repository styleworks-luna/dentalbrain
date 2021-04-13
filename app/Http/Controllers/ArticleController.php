<?php

namespace App\Http\Controllers;

use App\Models\Manage\Article;
use App\Models\Manage\ArticleCategory;
use App\Models\Manage\ArticleLike;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('like');
    }

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

    public function view(Article $article)
    {
        $article->views = $article->views + 1;
        return response()->json();
    }

    public function like(Request $request, Article $article)
    {
        if ($request->get('like') == 'true') {
            ArticleLike::query()->updateOrCreate([
                'user_id' => Auth::id(),
                'article_id' => $article->id
            ]);
        } elseif ($request->get('like') == 'false') {
            ArticleLike::query()->where('user_id', '=', Auth::id())
                ->where('article_id', '=', $article->id)
                ->delete();
        } else {
            return response()->json([
                'code' => 3,
                'cnt' => $article->likes_count,
            ], 400);
        }

        $article->refresh();

        return response()->json([
            'code' => 1,
            'cnt' => $article->likes_count,
        ], 200);
    }
}
