<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected $token;

    public function __construct()
    {
        $this->token = config('fonnte.token');
    }

    public function sendMessage($target, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
            'delay' => '2', // Jeda antar pesan untuk menghindari spam filter
        ]);

        return $response->json();
    }
}
