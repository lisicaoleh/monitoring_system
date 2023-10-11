<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PositionRepositoryInterface
{
    public function getAddPositions(): Collection|null;
}
