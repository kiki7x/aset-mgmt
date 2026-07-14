<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReminderLog extends Model
{
    protected $table = 'reminder_logs';

    protected $fillable = [
        'maintenance_schedule_id',
        'sent_at',
        'channel',
        'status',
        'response',
    ];

    public function maintenanceSchedule(): BelongsTo
    {
        return $this->belongsTo(Maintenances_scheduleModel::class, 'maintenance_schedule_id');
    }
}
