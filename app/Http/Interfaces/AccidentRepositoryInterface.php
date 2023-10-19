<?php

namespace App\Http\Interfaces;

use App\Models\Accident;

interface AccidentRepositoryInterface
{
    public function create(int $facilityId, int $constructionId, array $notifiedUsers, string $date): Accident;
}
