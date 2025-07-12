<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\UserRepository;
use Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(RegisterUserRequest $request)
    {
        // Get validated input data (already validated by UserRequest)
        $data = $request->validated();

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

        $this->userRepo->createUser($userData);

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

        $user = $this->userRepo->findOneUser(["email" => $body["email"]]);

        if (!$user)
            return ApiResponse::error(404, "There is no any user with such email address.");


        if (!Hash::check($body["password"], $user["password"]))
            return ApiResponse::error(401, "Invalid password.");

        $token = $user->createToken("api")->plainTextToken;

        return ApiResponse::success(200, "Login successful", ["token" => $token]);
    }
    public function me(Request $request)
    {
        $authHeader = $request->header('Authorization');

        // Remove Bearer from first of token
        $accessToken = substr($authHeader, 7);

        $token = PersonalAccessToken::findToken($accessToken);

        $user = $token->tokenable;

        return ApiResponse::success(200, "User info retrieved successfully", ["userInfo" => $user]);
    }
}
