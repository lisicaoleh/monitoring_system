<?php

namespace App\Http\Interfaces;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

interface PositionRepositoryInterface
{
    public function getAddPositions(): Collection|null;
    public function getPositionById(int $id): Position|null;
}
