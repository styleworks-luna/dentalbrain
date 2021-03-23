<?php


namespace App\Services\File;


use App\Models\Manage\Article;

class ArticleFile extends FileTemplate
{

    public function __construct(Article $article)
    {
        parent::__construct($article);
    }

    protected function getSavePath(string $fileName)
    {
        $article = $this->model;
        return $path = 'public/articles/' . $article->id . '/thumbnail/' . $fileName;
    }

    protected function deleteFileInDB()
    {
        $article = $this->model;
        $path = $article->thumbnail->path;
        $article->thumbnail->delete();
        return $path;
    }
}
