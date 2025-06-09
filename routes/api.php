<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\isLogged;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;


Route::prefix("auth")->group(function () {
    Route::post("/register", [UserController::class, "register"]);
    Route::post("/login", [UserController::class, "login"]);
    Route::middleware(isLogged::class)->get("/me", [UserController::class, "me"]);
});

Route::prefix("article")->group(function () {
    Route::middleware(isLogged::class)->post("/create", [ArticleController::class, "create"]);
    Route::middleware(isLogged::class)->get("/getAll", [ArticleController::class, "getAll"]);
    Route::get("/get/{article_id}");
});
