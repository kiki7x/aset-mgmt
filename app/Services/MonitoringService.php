<?php

namespace App\Services;

use App\Models\Monitor;
use App\Models\MonitorHeartbeat;
use Illuminate\Support\Facades\Http;

class MonitoringService
{
    /**
     * Cek satu monitor, catat heartbeat, update cache di tabel monitors.
     *
     * @return MonitorHeartbeat
     */
    public function check(Monitor $monitor): MonitorHeartbeat
    {
        $status = 'down';
        $statusCode = null;
        $error = null;
        $responseTime = null;

        $start = microtime(true);

        try {
            $response = Http::timeout(10)
                ->withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'SAPA-PPL-Monitor/1.0',
                ])
                ->get($monitor->url);

            $responseTime = (int) round((microtime(true) - $start) * 1000);
            $statusCode = $response->status();

            if ($statusCode < 500) {
                $status = 'up';
                if ($statusCode >= 400) {
                    $error = "HTTP {$statusCode} (server merespons)";
                }
            } else {
                $status = 'down';
                $error = "HTTP {$statusCode}";
            }
        } catch (\Throwable $e) {
            $responseTime = (int) round((microtime(true) - $start) * 1000);
            $status = 'down';
            $error = $e->getMessage();
        }

        $heartbeat = MonitorHeartbeat::create([
            'monitor_id' => $monitor->id,
            'status' => $status,
            'response_time' => $responseTime,
            'status_code' => $statusCode,
            'error' => $error,
            'checked_at' => now(),
        ]);

        $monitor->update([
            'last_checked_at' => now(),
            'last_status' => $status,
            'last_response_time' => $responseTime,
        ]);

        return $heartbeat;
    }
}
