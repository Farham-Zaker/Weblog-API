<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    public function createArticle(array $data)
    {
        return Article::create($data);
    }
    public function getAllArticleByWriterId(string $writer_id)
    {
        return Article::where("writer_id", $writer_id)->get();
    }
    public function getAllArticle()
    {
        return Article::all();
    }
    public function getOneArticleById(string $article_id)
    {
        return Article::where("id", $article_id)->first();
    }
    public function updateArticle(array $where, array $data)
    {
        return Article::where($where)->update($data);
    }
}
