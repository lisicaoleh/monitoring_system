<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Repositories\AccidentRepository;
use App\Repositories\ConstructionRepository;
use App\Repositories\UserRepository;
use App\Services\AccidentService;
use Illuminate\Http\JsonResponse;

class AccidentController extends Controller
{
    public function __construct(
        protected ConstructionRepository $constructionRepository,
        protected AccidentRepository $accidentRepository,
        protected AccidentService $accidentService
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
}
