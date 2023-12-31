<?php

namespace App\Http\Interfaces;

use App\Models\Facility;

interface FacilityRepositoryInterface
{
    public function getFacilityById(int $id): Facility|null;
    public function getFacilityByName(string $name): Facility|null;
    public function create(array $data): Facility|null;
    public function update(Facility $facility, array $data): bool;
}
