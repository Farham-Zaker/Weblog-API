<?php

namespace App\Repositories;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class UserRepository
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }
    public function findOneUser($where)
    {
        return User::where($where)->first();
    }
    public function findUserByToken(string $authToken)
    {
        $token = PersonalAccessToken::findToken($authToken);

        $user = $token->tokenable;

        return $user;
    }
}
