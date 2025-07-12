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
    Route::middleware(isLogged::class)->get("/get/{article_id}/comments", [ArticleController::class, "getComments"]);
    Route::middleware(isLogged::class, CheckArticleWriter::class)->put("/update", [ArticleController::class, "update"]);
    Route::middleware(isLogged::class, CheckArticleWriter::class)->delete("/delete/{article_id}", [ArticleController::class, "delete"]);
    Route::get("/pdf/{article_id}", [ArticleController::class, "exportPdf"]);
});

Route::prefix("comment")->group(function () {
    Route::middleware(isLogged::class)->post("/create", [CommentController::class, "create"]);
    Route::get("/getAll/{article_id}",[CommentController::class,"getAllByArticleId"]);
    Route::get("/get/{comment_id}", [CommentController::class, "getById"]);
    Route::middleware(isLogged::class)->put("/update", [CommentController::class, "update"]);
    Route::middleware(isLogged::class)->delete("/delete/{comment_id}", [CommentController::class, "delete"]);
});
