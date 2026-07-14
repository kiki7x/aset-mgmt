<?php

namespace App\Console\Commands;

use App\Models\MonitorHeartbeat;
use Illuminate\Console\Command;

class MonitorCleanupCommand extends Command
{
    protected $signature = 'app:monitor-cleanup';

    protected $description = 'Hapus data heartbeat monitor yang lebih tua dari retensi (config)';

    public function handle()
    {
        $retentionDays = (int) config('monitoring.retention_days', 730);
        $cutoff = now()->subDays($retentionDays);

        $deleted = MonitorHeartbeat::where('checked_at', '<', $cutoff)->delete();

        $this->info("Cleanup selesai. {$deleted} heartbeat lebih tua dari {$retentionDays} hari dihapus.");
        return Command::SUCCESS;
    }
}
