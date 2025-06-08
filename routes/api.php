<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\isLogged;
use Illuminate\Support\Facades\Route;


Route::prefix("auth")->group(function () {
    Route::post("/register", [UserController::class, "register"]);
    Route::post("/login", [UserController::class, "login"]);
    Route::middleware(isLogged::class)->get("/me", [UserController::class, "me"]);
});
