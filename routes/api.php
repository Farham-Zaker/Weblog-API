<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\isLogged;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Middleware\CheckArticleWriter;
use App\Http\Controllers\CommentController;

Route::prefix("auth")->group(function () {
    Route::post("/register", [UserController::class, "register"]);
    Route::post("/login", [UserController::class, "login"]);
    Route::middleware(isLogged::class)->get("/me", [UserController::class, "me"]);
});

Route::prefix("article")->group(function () {
    Route::middleware(isLogged::class)->post("/create", [ArticleController::class, "create"]);
    Route::middleware(isLogged::class)->get("/my", [ArticleController::class, "my"]);
    Route::get("/public", [ArticleController::class, "public"]);
    Route::get("/get/{article_id}", [ArticleController::class, "getById"]);
    Route::middleware(CheckArticleWriter::class)->put("/update", [ArticleController::class, "update"]);
});

Route::prefix("comment")->group(function () {
    Route::middleware(isLogged::class)->post("/create", [CommentController::class, "create"]);
    Route::get("/get/{comment_id}");
});
