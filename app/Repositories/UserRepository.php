<?php

namespace App\Repositories;

use App\Http\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function getUserByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }
}
