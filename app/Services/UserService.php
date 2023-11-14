<?php

namespace App\Services;

use App\Models\FacilityUser;
use App\Models\User;
use App\Repositories\FacilityRepository;
use App\Repositories\PositionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected FacilityRepository $facilityRepository,
        protected PositionRepository $positionRepository
    )
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

    public function registerUserValidation(array $userData, $user = null): string|null
    {
        if (isset($userData['position_id']) && !$this->positionRepository->getPositionById($userData['position_id'])) {
            return __('Position not found');
        }

        if (!isset($userData['facility_id']) && Auth::user()->role !== config('app.user_roles.admin')) {
            return __('facility_id field is required');
        }

        if (
            !$this->facilityRepository->getFacilityById($userData['facility_id'])
        ) {
            return __('Facility not found');
        }

        if ($user && FacilityUser::where('user_id', $user->id)->where('facility_id', $userData['facility_id'])->first()) {
            return __('User already added to facility with ID '.$userData['facility_id']);
        }
        return null;
    }

    public function updateUserValidation(array $userData, User $user): string|null
    {
        if (
            isset($userData['email']) && $user['email'] !== $userData['email']
            && ! empty($this->userRepository->getUserByEmail($userData['email']))
        ) {
            return __('Email is already exist');
        }

        if (
            isset($userData['mobile']) && $user['mobile'] !== $userData['mobile']
            && ! empty($this->userRepository->getUserByMobile($userData['mobile']))
        ) {
            return __('Mobile number is already registered');
        }

        return null;
    }

    public function userUpdatePermissionCheck(User $user): bool
    {
        $currentUser = Auth::user();
        $flag = 0;

        if ($currentUser->id === $user->id) {
            $flag = 1;
        }

        if ($user->role === config('app.user_roles.user') || $user->role === config('app.user_roles.manager')) {
            $flag = 1;
        }

        return $flag;
    }
}
