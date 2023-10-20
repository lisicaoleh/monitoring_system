<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioService
{
    public function sendSMS(string $number, string $text): bool
    {
        //TODO add check if message haven`t sent
        try {
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.auth_token');
            $twilio = new Client($sid, $token);

            $twilio->messages
                ->create($number,
                    array(
                        "from" => config('services.twilio.phone_number'),
                        "body" => $text
                    )
                );
        } catch (TwilioException $e) {
            Log::error('Error Twilio: ' . $e->getMessage());
            return false;
        }
        return true;
    }
}
