<?php

namespace App\Http\Interfaces;

use App\Models\Construction;

interface ConstructionRepositoryInterface
{
    public function create(array $data): Construction|null;
    public function getConstructionById(int $id): Construction|null;
    public function update(Construction $construction, array $data): bool;
}
