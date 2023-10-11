<?php

namespace App\Http\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUserByEmail(string $email): User|null;
}
