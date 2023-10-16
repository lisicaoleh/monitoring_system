<?php

namespace App\Services;

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

    public function registerUserValidation(array $userData, User $user = null): string|null
    {
        if (
            $user && isset($userData['email']) && $user['email'] !== $userData['email']
            && ! empty($this->userRepository->getUserByEmail($userData['email']))
            || !isset($user) && ! empty($this->userRepository->getUserByEmail($userData['email']))
        ) {
            return __('Email is already exist');
        }

        if (
            $user && isset($userData['mobile']) && $user['mobile'] !== $userData['mobile']
            && ! empty($this->userRepository->getUserByMobile($userData['mobile']))
            || !isset($user) && ! empty($this->userRepository->getUserByMobile($userData['mobile']))
        ) {
            return __('Mobile number is already registered');
        }

        if (isset($userData['position_id']) && !$this->positionRepository->getPositionById($userData['position_id'])) {
            return __('Position not found');
        }

        if (!isset($userData['facility_id']) && Auth::user()->role !== config('app.user_roles.admin') && !$user) {
            return __('facility_id field is required');
        }

        if (
            $user && isset($userData['facility_id']) && !$this->facilityRepository->getFacilityById($userData['facility_id'])
            || !$user && !$this->facilityRepository->getFacilityById($userData['facility_id'])
        ) {
            return __('Facility not found');
        }

        return null;
    }

    public function checkManagerOrSelfUser(User $user): bool
    {
        $currentUser = Auth::user();
        return $currentUser->role === config('app.user_roles.manager') || $currentUser->id === $user->id;
    }
}
