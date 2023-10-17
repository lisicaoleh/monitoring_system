<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\ConstructionStoreRequest;
use App\Http\Requests\API\ConstructionUpdateRequest;
use App\Models\Construction;
use App\Repositories\ConstructionRepository;
use App\Repositories\FacilityRepository;
use Illuminate\Http\JsonResponse;

class ConstructionController extends Controller
{
    public function __construct(
        protected ConstructionRepository $constructionRepository,
        protected FacilityRepository $facilityRepository
    )
    {
        //
    }

    public function store(ConstructionStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (!$this->facilityRepository->getFacilityById($validated['facility_id'])) {
            return response()->json(['message' => 'Facility not found'], 400);
        }
        $construction = $this->constructionRepository->create($validated);
        if ($construction instanceof Construction) {
            return response()->json($construction, 201);
        }

        return response()->json(['message' => 'Something went wrong'], 500);
    }

    public function update(int $id, ConstructionUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $construction = $this->constructionRepository->getConstructionById($id);
        if (! $construction) {
            return response()->json(['message' => 'Construction not found'], 400);
        }

        if ($this->constructionRepository->update($construction, $validated)) {
            return response()->json(['message' => 'Construction updated successfully']);
        }

        return response()->json(['message' => 'Something went wrong'], 500);
    }

    public function delete(int $id): JsonResponse
    {
        if (Construction::destroy($id)) {
            return response()->json('1', 204);
        }

        return response()->json(['message' => 'Something went wrong'], 500);
    }
}
