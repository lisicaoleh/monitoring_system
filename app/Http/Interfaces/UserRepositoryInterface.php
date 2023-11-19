<?php

namespace App\Http\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function getUserById(int $id): User|null;
    public function getUserByEmail(string $email): User|null;
    public function getUserByMobile(string $mobile): User|null;
    public function create(array $userData): User|null;
    public function update(User $user, array $userData): bool;
    public function checkIsUserReceiveNotif(User $user): bool;
    public function addToFacility(User $user, int $facilityId): void;
}
