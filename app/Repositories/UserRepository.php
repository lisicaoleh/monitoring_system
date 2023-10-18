<?php

namespace App\Repositories;

use App\Http\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function getUserById(int $id): User|null
    {
        return User::find($id);
    }

    public function getUserByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    public function getUserByMobile(string $mobile): User|null
    {
        return User::where('mobile', $mobile)->first();
    }

    public function create(array $userData): User|null
    {
        return User::create($userData);
    }

    public function update(User $user, array $userData): bool
    {
        return $user->update($userData);
    }
}
