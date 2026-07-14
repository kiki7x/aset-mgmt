<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitorHeartbeat extends Model
{
    protected $table = 'monitor_heartbeats';

    protected $fillable = [
        'monitor_id',
        'status',
        'response_time',
        'status_code',
        'error',
        'checked_at',
    ];

    protected function casts(): array
    {
        return [
            'checked_at' => 'datetime',
        ];
    }

    public function monitor(): BelongsTo
    {
        return $this->belongsTo(Monitor::class);
    }
}
