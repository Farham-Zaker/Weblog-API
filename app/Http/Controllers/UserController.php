<?php

namespace App\Http\Controllers;

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
  
}
