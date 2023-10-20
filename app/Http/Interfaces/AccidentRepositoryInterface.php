<?php

namespace App\Http\Interfaces;

use App\Models\Accident;
use Illuminate\Database\Eloquent\Collection;

interface AccidentRepositoryInterface
{
    public function create(int $facilityId, int $constructionId, array $notifiedUsers, string $date): Accident;
    public function getAccidentByFacilityId(int $id): Collection;
    public function getAccidentById(int $id): Accident|null;
}
