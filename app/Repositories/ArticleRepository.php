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
}
