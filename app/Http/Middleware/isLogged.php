<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class isLogged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return ApiResponse::error(401, "Token not provided.");
        }
        // Remove Bearer from first of token
        $accessToken = substr($authHeader, 7);

        $token = PersonalAccessToken::findToken($accessToken);

        if (!$token || !$token->tokenable) {
            return ApiResponse::error(401, "Invalid or expired token.");
        }

        return $next($request);
    }
}
