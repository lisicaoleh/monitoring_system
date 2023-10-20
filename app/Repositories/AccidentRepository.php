<?php

namespace App\Repositories;

use App\Http\Interfaces\AccidentRepositoryInterface;
use App\Models\Accident;
use Illuminate\Database\Eloquent\Collection;

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

    public function getAccidentByFacilityId(int $id): Collection
    {
        return Accident::where('facility_id', $id)->get();
    }

    public function getAccidentById(int $id): Accident|null
    {
        return Accident::find($id);
    }
}
