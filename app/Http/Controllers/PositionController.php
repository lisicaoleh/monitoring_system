<?php

namespace App\Http\Controllers;

use App\Repositories\PositionRepository;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    public function __construct(
        protected PositionRepository $positionRepository
    )
    {
        //
    }
    public function index(): JsonResponse
    {
        return response()->json($this->positionRepository->getAddPositions());
    }
}
