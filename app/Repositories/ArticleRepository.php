<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository {
    public function createArticle(array $data){
        return Article::create($data);
    }
}