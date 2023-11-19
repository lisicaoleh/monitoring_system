<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected UserRepository $userRepository
    )
    {
        //
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $this->userService->loginUserValidation($validated['email'], $validated['password']);
        if (!$user instanceof User) {
            return response()->json(['message' => $user], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $this->userRepository->getUserByEmail($validated['email']);
        $validation = $this->userService->registerUserValidation($validated, $user);

        if ($validation) {
            return response()->json(['message' => $validation], 400);
        }

        if (!$user) {
            $user = $this->userRepository->create($validated);
        }
        $this->userRepository->addToFacility($user, $validated['facility_id']);

        if ($user instanceof User) {
            return response()->json($user, 201);
        }
        //TODO send email with login credentials

        return response()->json(['message' => 'Something went wrong'], 500);
    }
}
