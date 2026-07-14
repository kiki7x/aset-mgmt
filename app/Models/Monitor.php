<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Monitor extends Model
{
    protected $table = 'monitors';

    protected $fillable = [
        'name',
        'type',
        'url',
        'interval',
        'is_active',
        'last_checked_at',
        'last_status',
        'last_response_time',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_checked_at' => 'datetime',
        ];
    }

    public function heartbeats(): HasMany
    {
        return $this->hasMany(MonitorHeartbeat::class);
    }

    /**
     * Persentase uptime dalam rentang jam terakhir.
     */
    public function uptimePercentage(int $hours = 24): float
    {
        $since = now()->subHours($hours);
        $total = $this->heartbeats()->where('checked_at', '>=', $since)->count();

        if ($total === 0) {
            return 0.0;
        }

        $up = $this->heartbeats()
            ->where('checked_at', '>=', $since)
            ->where('status', 'up')
            ->count();

        return round(($up / $total) * 100, 2);
    }

    /**
     * Apakah monitor ini sudah waktunya dicek (berdasar interval).
     */
    public function isDue(): bool
    {
        if (!$this->last_checked_at) {
            return true;
        }

        return $this->last_checked_at->addMinutes($this->interval)->isPast();
    }
}
