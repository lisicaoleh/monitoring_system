<?php

namespace App\Http\Controllers;

use App\Mails\Accident;
use App\Models\Construction;
use App\Repositories\ConstructionRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AccidentController extends Controller
{
    public function __construct(
        protected ConstructionRepository $constructionRepository,
        protected UserRepository $userRepository
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

        $notifiedUsers = [];
        foreach ($users as $user) {

            if (!$this->userRepository->checkIsUserReceiveNotif($user)) {
                continue;
            }

            $notification = [
                'user_id' => $user->id,
                'is_email_sent' => false,
                'is_sms_sent' => false,
                'is_push_sent' => false
            ];

            if ($user->is_receive_email_notif) {
                try {
                    Mail::to($user->email)->send(new Accident($construction->name, date(now()), $user->first_name, $user->last_name));
                    $notification['is_email_sent'] = true;
                } catch (Exception $e) {
                    Log::error('Send accident email error: ' . $e->getMessage());
                }
            }

            if ($user->is_receive_sms_notif) {
                //TODO implement sms notification
            }

            if ($user->is_receive_push_notif) {
                //TODO implement PUSH notification
            }

            $notifiedUsers[] = $notification;
        }


        return response()->json('Accident committed');
    }
}
