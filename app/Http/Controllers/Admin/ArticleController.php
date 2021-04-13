<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manage\Article;
use App\Models\Manage\ArticleCategory;
use App\Services\File\ArticleFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()->orderByDesc('date')->paginate(10);

        return response()->json([
            'articles' => $articles,
        ]);
    }

    public function categories()
    {
        return response()->json([
            ArticleCategory::all()
        ]);
    }

    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'category_id' => ['required', Rule::exists('article_categories', 'id')],
            'title' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string', 'max:60000'],
            'writer' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'is_open' => ['required', 'boolean'],
        ]);

        $data = $v->validate();

        Article::create($data);

        return response()->json([
            'msg' => '생성되었습니다.',
        ], 201);
    }

    public function edit(Request $request, Article $article)
    {
        return response()->json([
            'article' => $article
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $v = Validator::make($request->all(), [
            'category_id' => ['required', Rule::exists('article_categories', 'id')],
            'title' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string', 'max:60000'],
            'writer' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'is_open' => ['required', 'boolean'],
        ]);

        $data = $v->validate();

        $article->update($data);

        return response()->json([
            'msg' => '수정되었습니다.',
        ], 200);
    }

    public function destroy(Request $request, Article $article)
    {
        $article->delete();

        return response()->json([
            'msg' => '삭제되었습니다.',
        ], 200);
    }
}
