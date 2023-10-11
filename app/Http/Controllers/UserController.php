<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected UserRepository $userRepository
    )
    {
        //
    }

    public function getRoles(): JsonResponse
    {
        return response()->json(config('app.user_roles'));
    }
}
