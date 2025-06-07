<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\UserRepository;
use Hash;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        // Get validated input data (already validated by UserRequest)
        $data = $request->validated();

        // Initialize UserRepository for user operations
        $userRepo = new UserRepository();

        // Get client IP address
        $client_ip = $request->getClientIp();

        $userData = [
            "username" => $data["username"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"]),
            "reg_ip" => $client_ip,
            "last_login" => now(),
            "last_ip" => $client_ip
        ];

        $userRepo->createUser($userData);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'User registered successfully.',
            'data' => $userData
        ]);
    }
    public function login(LoginUserRequest $request)
    {
        $body = $request->validated();
        $userRepo = new UserRepository();


        $user = $userRepo->findOneUser(["email" => $body["email"]]);

        if (!$user)
            return ApiResponse::error(404, "There is no any user with such email address.");


        if (!Hash::check($body["password"], $user["password"]))
            return ApiResponse::error(401, "Invalid password.");

        $token = $user->createToken("api")->plainTextToken;

        return ApiResponse::success(200, "Login successful", ["token" => $token]);
    }
}
