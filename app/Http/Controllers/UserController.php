<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\UserUpdateRequest;
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

    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->getUserById($id);
        return response()->json($user);
    }

    public function update(int $id, UserUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $this->userRepository->getUserById($id);
        if (!$this->userService->checkManagerOrSelfUser($user)) {
            return response()->json(['message' => 'Permission denied'], 403);
        }
        $validation = $this->userService->registerUserValidation($validated, $user);
        if ($validation) {
            return response()->json(['message' => $validation], 400);
        }

        if ($this->userRepository->update($user, $validated)) {
            return response()->json($user);
        }

        return response()->json(['message' => 'Something went wrong'], 500);
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
