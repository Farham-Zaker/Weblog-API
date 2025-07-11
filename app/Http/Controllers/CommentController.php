<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class CommentController
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

        $createdComment = $this->commentRepo->create([
            "comment"  =>  $comment,
            "article_id"  => $article_id,
            "user_id" => $loggedInUser["id"]
        ]);

        return ApiResponse::success(200, "The comment successfuly created.", [$createdComment]);
    }
    public function getAllByArticleId($article_id)
    {
        $article = $this->articleRepo->getOneArticleById($article_id);

        if (!$article) return ApiResponse::error(404, "There is no any article with such ID.");

        $articleComments = $this->commentRepo->getAll(["article_id" => $article_id]);

        return ApiResponse::success(200, "The comments retrieved successfully.", $articleComments);
    }
    public function getById($comment_id)
    {
        $comment = $this->commentRepo->getById($comment_id);

        if (!$comment) return ApiResponse::error(404, "There is no any comment with such ID.");

        return ApiResponse::success(200, "The articles retrieved successfully.", [$comment]);
    }
    public function update(UpdateCommentRequest $request)
    {
        $authToken = $request->header("Authorization");

        // Find the currently logged-in user using the token
        $user = $this->userRepo->findUserByToken($authToken);

        [
            "comment_id"  =>   $comment_id,
            "comment"     =>   $newCommentText
        ] = $request->validated();


        $comment = $this->commentRepo->getById($comment_id);

        // Check if the logged-in user is the author of the comment
        if ($comment->user_id !== $user["id"]) return ApiResponse::error(403, "You are not allowed to update this comment.");

        // Update the comment
        $this->commentRepo->update(
            ["id" => $comment_id],
            ["comment" => $newCommentText]
        );

        return ApiResponse::success(200, "The comment updated successfully.", ["ds" => $comment]);
    }
    public function delete($comment_id, Request $request)
    {
        $authToken = $request->header("Authorization");

        // Find the currently logged-in user using the token
        $user = $this->userRepo->findUserByToken($authToken);

        $comment = $this->commentRepo->getById($comment_id);
        if (!$comment) return ApiResponse::error(404, "There is no any comment with such ID.");

        // Check if the logged-in user is the author of the comment
        if ($comment->user_id !== $user["id"]) return ApiResponse::error(403, "You are not allowed to delete this comment.");

        $this->commentRepo->delete($comment_id);

        return ApiResponse::success(200, "The comment deleted successfully.");
    }
}
