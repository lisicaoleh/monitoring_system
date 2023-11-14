<?php

namespace App\Repositories;

use App\Http\Interfaces\FacilityRepositoryInterface;
use App\Models\Facility;

class FacilityRepository implements FacilityRepositoryInterface
{
    public function getFacilityById(int $id): Facility|null
    {
        return Facility::with('users')->find($id);
    }

    public function getFacilityByName(string $name): Facility|null
    {
        return Facility::where('name', $name)->first();
    }

    public function create(array $data): Facility|null
    {
        return Facility::create($data);
    }

    public function update(Facility $facility, array $data): bool
    {
        return $facility->update($data);
    }
}
