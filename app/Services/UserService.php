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

    public function registerUserValidation(array $user): string|null
    {
        if (! empty($this->userRepository->getUserByEmail($user['email']))) {
            return __('Email is already exist');
        }

        if (! empty($this->userRepository->getUserByMobile($user['mobile']))) {
            return __('Mobile number is already registered');
        }

        if (isset($user['position_id']) && !$this->positionRepository->getPositionById($user['position_id'])) {
            return __('Position not found');
        }

        if (!isset($user['facility_id']) && Auth::user()->role !== config('app.user_roles.admin')) {
            return __('facility_if field is required');
        }

        if (!$this->facilityRepository->getFacilityById($user['facility_id'])) {
            return __('Facility not found');
        }

        return null;
    }
}
