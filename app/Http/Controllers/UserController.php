<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['User not found'], 400);
        }
        $user->delete();
        return response()->json('', 204);
    }
}
