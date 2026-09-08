<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send an SMS. Falls back to logging the message if Twilio
     * credentials aren't configured yet, so you can test the
     * OTP flow locally before setting up a real SMS provider.
     */
    public function send(string $phoneNumber, string $message): void
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');

        if (! $sid || ! $token || ! $from) {
            Log::info("[DEV SMS] To: {$phoneNumber} | Message: {$message}");
            return;
        }

        // Requires: composer require twilio/sdk
        $client = new \Twilio\Rest\Client($sid, $token);

        $client->messages->create($phoneNumber, [
            'from' => $from,
            'body' => $message,
        ]);
    }
}