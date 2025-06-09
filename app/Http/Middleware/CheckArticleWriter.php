<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ApiResponse;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckArticleWriter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authToken = $request->header("Authorization");
        $article_id = $request->input("article_id");

        $userRepo = new UserRepository();
        $articleRepo = new ArticleRepository();

        // Find the user based on the sent token
        $user = $userRepo->findUserByToken($authToken);

        // Find the article by id of article
        $article = $articleRepo->getOneArticleById($article_id);

        // Check if logged in user is writer of this article or not
        if ($article->writer_id != $user->id) return ApiResponse::error(403, "You are not writer of this article.");

        return $next($request);
    }
}
