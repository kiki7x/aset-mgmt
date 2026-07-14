<?php

namespace App\Console\Commands;

use App\Models\Monitor;
use App\Services\MonitoringService;
use Illuminate\Console\Command;

class MonitorHeartbeatCommand extends Command
{
    protected $signature = 'app:monitor-heartbeat';

    protected $description = 'Cek heartbeat semua monitor aktif yang sudah waktunya dicek';

    public function handle(MonitoringService $service)
    {
        $monitors = Monitor::where('is_active', true)->get();

        if ($monitors->isEmpty()) {
            $this->info('Tidak ada monitor aktif.');
            return Command::SUCCESS;
        }

        $checked = 0;

        foreach ($monitors as $monitor) {
            if (!$monitor->isDue()) {
                continue;
            }

            $heartbeat = $service->check($monitor);
            $checked++;

            $this->info("[{$monitor->name}] {$heartbeat->status} ({$heartbeat->response_time} ms)");
        }

        $this->info("Selesai. {$checked} monitor dicek.");
        return Command::SUCCESS;
    }
}
