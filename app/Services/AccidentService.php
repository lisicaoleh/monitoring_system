<?php

namespace App\Services;

use App\Mails\Accident;
use App\Models\Construction;
use App\Models\User;
use App\Repositories\AccidentRepository;
use App\Repositories\ConstructionRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AccidentService
{
    public function __construct(
        protected ConstructionRepository $constructionRepository,
        protected UserRepository $userRepository,
        protected AccidentRepository $accidentRepository
    )
    {
        //
    }

    public function notifyUser(User $user, Construction $construction, string $date): array|null
    {
        if (!$this->userRepository->checkIsUserReceiveNotif($user)) {
            return null;
        }

        $notification = [
            'user_id' => $user->id,
            'is_email_sent' => false,
            'is_sms_sent' => false,
            'is_push_sent' => false
        ];

        if ($user->is_receive_email_notif) {
            $notification['is_email_sent'] = $this->sendMail($user, $construction, $date);
        }

        if ($user->is_receive_sms_notif) {
            //TODO implement sms notification
        }

        if ($user->is_receive_push_notif) {
            //TODO implement PUSH notification
        }

        return $notification;
    }

    private function sendMail(User $user, Construction $construction, string $date): bool
    {
        try {
            Mail::to($user->email)->send(new Accident($construction->name, $date, $user->first_name, $user->last_name));
            return true;
        } catch (Exception $e) {
            Log::error('Send accident email error: ' . $e->getMessage());
            return false;
        }
    }
}
