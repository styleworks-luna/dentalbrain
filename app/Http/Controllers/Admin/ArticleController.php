<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Manage\Article;
use App\Services\File\ArticleFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()->orderByDesc('date')->paginate(10);

        return response()->json([
            'articles' => $articles,
        ]);
    }

    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:200'],
            'link' => ['required', 'string', 'max:200'],
            'date' => ['required', 'datetime'],
            'thumbnail_id' => ['required', 'numeric'],
        ]);

        $data = $v->validate();

        $article = Article::create($data);

        $articleFile = new ArticleFile($article);
        $articleFile->moveTempToPublic(File::find($data['thumbnail_id']));

        return response()->json([
            'alert' => '생성되었습니다.',
        ], 201);
    }

    public function edit(Request $request, Article $article)
    {
        return response()->json([
            'article' => $article,
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $v = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:200'],
            'link' => ['required', 'string', 'max:200'],
            'date' => ['required', 'datetime'],
            'thumbnail_id' => ['required', 'numeric'],
        ]);

        $data = $v->validate();

        $article->update($data);

        return response()->json([
            'alert' => '수정되었습니다.',
        ], 200);
    }

    public function delete(Request $request, Article $article)
    {

        $articleFile = new ArticleFile($article);
        $articleFile->deleteFile();

        $article->delete();

        return response()->json([
            'alert' => '삭제되었습니다.',
        ], 200);
    }
}
