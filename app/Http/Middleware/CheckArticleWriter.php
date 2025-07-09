<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ApiResponse;
use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Mockery\Undefined;
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

        // Try to get article_id from body or route params
        $article_id = $request->input("article_id") ?? $request->route("article_id");

        if (!$article_id) {
            // If article_id is not provided at all
            return ApiResponse::error(400, "You must send article id.");
        }

        $userRepo = new UserRepository();
        $articleRepo = new ArticleRepository();

        // Find the user based on the sent token
        $user = $userRepo->findUserByToken($authToken);

        // Find the article by id of article
        $article = $articleRepo->getOneArticleById($article_id);
        if (!$article) return ApiResponse::error(404, "There is no any article with such article id.");

        // Check if logged in user is writer of this article or not
        if ($article->writer_id != $user->id) return ApiResponse::error(403, "You are not writer of this article.");

        return $next($request);
    }
}
