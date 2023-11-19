<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\UserDeleteRequest;
use App\Http\Requests\API\UserUpdateRequest;
use App\Models\Facility;
use App\Models\FacilityUser;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
        if (!$user) {
            return response()->json(['User not found'], 400);
        }

        if (!$this->userService->userUpdatePermissionCheck($user)) {
            return response()->json(['message' => 'Permission denied'], 403);
        }
        $validation = $this->userService->updateUserValidation($validated, $user);
        if ($validation) {
            return response()->json(['message' => $validation], 400);
        }

        if ($this->userRepository->update($user, $validated)) {
            return response()->json($user);
        }

        return response()->json(['message' => 'Something went wrong'], 500);
    }

    public function destroy(int $id, UserDeleteRequest $request): JsonResponse
    {
        $request = $request->validated();
        $user = User::find($id);
        if (!$user) {
            return response()->json(['User not found'], 400);
        }

        if (!$this->userService->userUpdatePermissionCheck($user)) {
            return response()->json(['message' => 'Permission denied'], 403);
        }

        if (isset($request['facility_id'])) {
            if (!FacilityUser::where('facility_id', $request['facility_id'])->where('user_id', $id)->first()) {
                return response()->json(['message' => 'The user with ID ' . $id . ' is not assigned to the facility with ID ' . $request['facility_id']], 400);
            }
            if (FacilityUser::where('user_id', $id)->count() === 1) {
                $user->delete();
            } else {
                FacilityUser::where('facility_id', $request['facility_id'])->where('user_id', $id)->delete();
            }
        } else {
            $user->delete();
        }
        return response()->json('1', 204);
    }

    public function getFacilities(): JsonResponse
    {
        $user = $this->userRepository->getUserById(Auth::id());
        if (!$user) {
            return response()->json(['User not found'], 400);
        }

        if ($user->role === config('app.user_roles.admin')) {
            return response()->json(Facility::all());
        }
        return response()->json($user->facilities);
    }
}
