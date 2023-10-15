<?php

namespace App\Repositories;

use App\Http\Interfaces\FacilityRepositoryInterface;
use App\Models\Facility;

class FacilityRepository implements FacilityRepositoryInterface
{
    public function getFacilityById(int $id): Facility|null
    {
        return Facility::find($id);
    }
}
