<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepository $userRepository)
    {
        //
    }

    public function loginUserValidation(string $email, string $password): string|User
    {
        if (empty($user = $this->userRepository->getUserByEmail($email))) {
            return __('User with this email does not exist in the system');
        }

        if (!Hash::check($password, $user->password)) {
            return __('User with this password does not exist in the system');
        }

        return $user;
    }
}
