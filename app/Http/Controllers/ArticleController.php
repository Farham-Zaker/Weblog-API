<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
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
    public function public(Request $request)
    {
        $articleRepo = new ArticleRepository();
        $articles = $articleRepo->getAllArticle();

        return ApiResponse::success(200, "Articles retrieved successfully.", [$articles]);
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
    public function update(UpdateArticleRequest $request)
    {
        $requestBody = $request->validated();
        $articleRepo = new ArticleRepository();

        // If neither title nor body is provided, return an error response
        if (!isset($requestBody["title"]) && !isset($requestBody["body"])) return ApiResponse::error(400, "No fields were provided for update.");

        // Prepare only the fields that were actually sent
        $updateFields = [];

        if (isset($requestBody["title"])) $updateFields["title"] = $requestBody["title"];
        if (isset($requestBody["body"])) $updateFields["body"] = $requestBody["body"];

        // Update the article using the provided article_id and updated fields
        $articleRepo->updateArticle(["id" => $requestBody["article_id"]], $updateFields);

        return ApiResponse::success(200, "Desired article updated successfuly.");
    }
}
