<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    protected ArticleRepository $articleRepo;
    protected UserRepository $userRepo;
    protected CommentRepository $commentRepo;

    public function __construct(ArticleRepository $articleRepo, UserRepository $userRepo, CommentRepository $commentRepo)
    {
        $this->articleRepo = $articleRepo;
        $this->userRepo = $userRepo;
        $this->commentRepo = $commentRepo;
    }

    public function create(CreateArticleRequest $request)
    {
        $token = $request->header("Authorization");
        [
            "title" => $title,
            "body"  => $body
        ] = $request->validated();

        $user = $this->userRepo->findUserByToken($token);

        $createdArticle = $this->articleRepo->createArticle([
            "title" => $title,
            "body"  => $body,
            "writer_id"  => $user["id"]
        ]);

        return ApiResponse::success(201, "The article successfuly created.", ["article" => $createdArticle]);
    }
    public function public(Request $request)
    {
        $articles = $this->articleRepo->getAllArticle();

        return ApiResponse::success(200, "Your articles retrieved successfully.", [$articles]);
    }
    public function my(Request $request)
    {
        $token = $request->header("Authorization");


        $user = $this->userRepo->findUserByToken($token);

        $allArticles = $this->articleRepo->getAllArticleByWriterId($user->id);
        return $allArticles;
    }
    public function getById($article_id)
    {

        $article = $this->articleRepo->getOneArticleById($article_id);

        if (!$article) return ApiResponse::error(404, "There is no any article with such article id.");

        return ApiResponse::success(200, "Articles retrieved successfully.", [$article]);
    }
    public function getComments($article_id)
    {
        $article = $this->articleRepo->getOneArticleById($article_id);

        // If the article does not exist, return an error response
        if (!$article) return ApiResponse::error(404, "There is no any article with such article id.");

        $comments = $this->commentRepo->getAll(["article_id" => $article_id]);

        // If there are no comments, return an error response
        if(count($comments) === 0) return ApiResponse::error(404, "There is no any comment for this article.");

        return ApiResponse::success(200, "Comments retrieved successfully.", [$comments]);
    }
    public function update(UpdateArticleRequest $request)
    {
        $requestBody = $request->validated();

        // If neither title nor body is provided, return an error response
        if (!isset($requestBody["title"]) && !isset($requestBody["body"])) return ApiResponse::error(400, "No fields were provided for update.");

        // Prepare only the fields that were actually sent
        $updateFields = [];

        if (isset($requestBody["title"])) $updateFields["title"] = $requestBody["title"];
        if (isset($requestBody["body"])) $updateFields["body"] = $requestBody["body"];

        // Update the article using the provided article_id and updated fields
        $this->articleRepo->updateArticle(["id" => $requestBody["article_id"]], $updateFields);

        return ApiResponse::success(200, "Desired article updated successfuly.");
    }
    public function delete($article_id) {
        // Check if the article exists
        $article = $this->articleRepo->getOneArticleById($article_id);
        if (!$article) return ApiResponse::error(404, "There is no any article with such article id.");

        // Delete all comments associated with the article
        $this->commentRepo->deleteAll(["article_id" => $article_id]);

        // Delete the article
        $this->articleRepo->deleteById($article_id);

        return ApiResponse::success(200, "The article deleted successfully.");
    }
}
