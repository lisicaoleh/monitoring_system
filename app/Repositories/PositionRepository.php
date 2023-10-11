<?php

namespace App\Repositories;

use App\Http\Interfaces\PositionRepositoryInterface;
use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

class PositionRepository implements PositionRepositoryInterface
{
    public function getAddPositions(): Collection|null
    {
        return Position::all();
    }
}
