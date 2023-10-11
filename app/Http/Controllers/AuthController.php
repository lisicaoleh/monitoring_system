<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\LoginRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        //
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userService->loginUserValidation($validated['email'], $validated['password']);
        if (!$user instanceof User) {
            return response()->json(['message' => $user], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
