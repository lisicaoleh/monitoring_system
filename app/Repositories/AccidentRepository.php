<?php

namespace App\Repositories;

use App\Http\Interfaces\AccidentRepositoryInterface;
use App\Models\Accident;

class AccidentRepository implements AccidentRepositoryInterface
{
    public function create(int $facilityId, int $constructionId, array $notifiedUsers, string $date): Accident
    {
        return Accident::create([
            'facility_id' => $facilityId,
            'construction_id' => $constructionId,
            'notified_users' => json_encode($notifiedUsers),
            'date' => $date
        ]);
    }
}
