<?php

namespace App\Http\Interfaces;

use App\Models\Facility;

interface FacilityRepositoryInterface
{
    public function getFacilityById(int $id): Facility|null;
    public function create(array $data): Facility|null;
}
