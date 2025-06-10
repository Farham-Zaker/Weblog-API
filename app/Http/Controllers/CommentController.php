<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Requests\CreateCommentRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{
    protected ArticleRepository $articleRepo;
    protected UserRepository $userRepo;
    protected CommentRepository $commentRepo;

    public function __construct(ArticleRepository $articleRepo, UserRepository $userRepo, CommentRepository $commentRepo)
    {
        $this->articleRepo = $articleRepo;
        $this->userRepo = $userRepo;
        $this->commentRepo =  $commentRepo;
    }

    public function create(CreateCommentRequest $request)
    {
        $authToken = $request->header("Authorization");

        [
            "comment"     =>  $comment,
            "article_id"  =>  $article_id,

        ] =  $request->validated();

        // Check if article is exist or not
        $article = $this->articleRepo->getOneArticleById($article_id);
        if (!$article) return ApiResponse::error(404, "There is any article with such id.");

        // Find logged in user from auth token
        $loggedInUser = $this->userRepo->findUserByToken($authToken);

        $this->commentRepo->create([
            "comment"  =>  $comment,
            "article_id"  => $article_id,
            "user_id" => $loggedInUser["id"]
        ]);

        return ApiResponse::success(200, "The comment successfuly created.", [$article]);
    }
}
