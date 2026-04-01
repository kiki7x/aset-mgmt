<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class WhatsappGroupController extends Controller
{
    public function getGroups()
    {
        $apiToken = env('FONNTE_TOKEN'); // Replace with your actual token

        try {
            $response = Http::withHeaders([
                'Authorization' => $apiToken,
            ])->post('https://api.fonnte.com/get-whatsapp-group');

            // Check if the request was successful and return the JSON response
            if ($response->successful()) {
                return $response->json(); // Returns the decoded JSON as an array/object
            } else {
                // Handle non-successful responses (e.g., 401, 500 errors)
                return response()->json([
                    'error' => 'API request failed',
                    'status' => $response->status(),
                    'message' => $response->body()
                ], $response->status());
            }

        } catch (\Exception $e) {
            // Handle connection errors or other exceptions
            return response()->json([
                'error' => 'An exception occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
