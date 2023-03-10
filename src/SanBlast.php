<?php

namespace SanBlast;
use Ixudra\Curl\Facades\Curl;

class SanBlast
{
    /**
     * @param string $string
     * @return string
     */
    public static function sanitize(string $string): string
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
        $string = strtolower($string); // Converts to lowercase.

        return $string;
    }

    public static function send($formData)
    {
        $token = env('SAN_BLAST_TOKEN');

        $response = Curl::to('https://blast.withsandev.com/api/send-message')
            ->withHeaders([
                'Authorization' => "Bearer {$token}"
            ])
            ->withData([
                'sender_phone_number' => $formData['sender_phone_number'],
                'receiver_phone_number' => $formData['receiver_phone_number'],
                'message' => $formData['message'],
            ])
            ->post();

        return $response;
    }
}
