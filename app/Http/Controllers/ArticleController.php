<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Requests\CreateArticleRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;

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
}
