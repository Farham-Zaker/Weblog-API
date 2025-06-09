<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Requests\CreateArticleRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Request;
use Validator;

class ArticleController extends Controller
{
    public function create(CreateArticleRequest $request)
    {
        $token = $request->header("Authorization");
        [
            "title" => $title,
            "body"  => $body
        ] = $request->validated();

        $articleRepo = new ArticleRepository();
        $userRepo = new UserRepository();

        $user = $userRepo->findUserByToken($token);

        $createdArticle = $articleRepo->createArticle([
            "title" => $title,
            "body"  => $body,
            "writer_id"  => $user["id"]
        ]);

        return ApiResponse::success(201, "The article successfuly created.", ["article" => $createdArticle]);
    }
    public function my(HttpRequest $request)
    {
        $token = $request->header("Authorization");

        $articleRepo = new ArticleRepository();
        $userRepo = new UserRepository();

        $user = $userRepo->findUserByToken($token);

        $allArticles = $articleRepo->getAllArticleByWriterId($user->id);
        return $allArticles;
    }
    public function getById($article_id)
    {
        $articleRepo = new ArticleRepository();

        $article = $articleRepo->getOneArticleById($article_id);

        if (!$article) return ApiResponse::error(404, "There is no any article with such article id.");

        return ApiResponse::success(200, "kdfk", [$article]);
    }
}
