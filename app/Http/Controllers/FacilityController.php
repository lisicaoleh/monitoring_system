<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\FacilityStoreRequest;
use App\Repositories\FacilityRepository;
use Illuminate\Http\JsonResponse;

class FacilityController extends Controller
{
    public function __construct(
        protected FacilityRepository $facilityRepository
    )
    {
        //
    }
    public function store(FacilityStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        return response()->json($this->facilityRepository->create($validated), 201);
    }

    public function show(int $id): JsonResponse
    {
        $facility = $this->facilityRepository->getFacilityById($id);
        if ($facility) {
            return response()->json([
                'id' => $facility->id,
                'name' => $facility->name,
                'constructions' => $facility->constructions
            ]);
        }
        return response()->json(['message' => 'Facility not found'], 400);
    }
}
