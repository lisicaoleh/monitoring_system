<?php

namespace App\Repositories;

use App\Http\Interfaces\ConstructionRepositoryInterface;
use App\Models\Construction;

class ConstructionRepository implements ConstructionRepositoryInterface
{
    public function getConstructionById(int $id): Construction|null
    {
        return Construction::find($id);
    }

    public function create(array $data): Construction|null
    {
        return Construction::create($data);
    }

    public function update(Construction $construction, array $data): bool
    {
        return $construction->update($data);
    }
}
