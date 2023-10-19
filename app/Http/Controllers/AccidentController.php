<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Repositories\AccidentRepository;
use App\Repositories\ConstructionRepository;
use App\Repositories\FacilityRepository;
use App\Repositories\UserRepository;
use App\Services\AccidentService;
use Illuminate\Http\JsonResponse;

class AccidentController extends Controller
{
    public function __construct(
        protected ConstructionRepository $constructionRepository,
        protected AccidentRepository $accidentRepository,
        protected AccidentService $accidentService,
        protected FacilityRepository $facilityRepository
    )
    {
        //
    }

    public function create(int $id): JsonResponse
    {
        $construction = $this->constructionRepository->getConstructionById($id);
        if (!$construction instanceof Construction) {
            return response()->json(['message' => 'Construction not found'], 400);
        }

        $users = $construction->facility->users;
        $date = date(now());

        $notifiedUsers = [];
        foreach ($users as $user) {
            $notifiedUser = $this->accidentService->notifyUser($user, $construction, $date);
            if ($notifiedUser) {
                $notifiedUsers[] = $notifiedUser;
            }
        }

        $this->accidentRepository->create($construction->facility->id, $construction->id, $notifiedUsers, $date);

        return response()->json('Accident committed');
    }

    public function index(int $id): JsonResponse
    {
        $facility = $this->facilityRepository->getFacilityById($id);
        if (! $facility) {
            return response()->json(['message' => 'Facility not found'], 400);
        }

        $accidents = $this->accidentRepository->getAccidentByFacilityId($id);
        $formattedAccidents = [];
        foreach ($accidents as $accident) {
            $construction = $this->constructionRepository->getConstructionById($accident->construction_id);
            $formattedAccidents[] = [
                'construction_id' => $construction->id,
                'construction_name' => $construction->name,
                'date' => $accident->date
            ];
        }

        return response()->json([
            'facility_id' => $facility->id,
            'facility_name' => $facility->name,
            'accidents' => $formattedAccidents
        ]);
    }
}
