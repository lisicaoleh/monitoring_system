<?php

namespace App\Http\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUserByEmail(string $email): User|null;
    public function getUserByMobile(string $mobile): User|null;
    public function create(array $userData): User|null;
}
