<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Cast\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenancesModel extends Model
{
    use HasFactory;
    protected $table = 'maintenances';
    protected $primaryKey = 'id';
    protected $fillable = [
        'maintenance_schedule_id',
        'asset_id',
        'pic_id',
        'ticketreply_id',
        'name',
        'description',
        'issuetype',
        'priority',
        'status',
        'period',
        'duedate',
        'created_by',
        'started_at',
        'completed_at',
        'timespent',
        'cost',
        'attachment',
        'notes',
        'customfields'
    ];

    public function maintenance_schedule(): BelongsTo
    {
        return $this->belongsTo(Maintenances_scheduleModel::class, 'maintenance_schedule_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(AssetsModel::class, 'asset_id');
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticketreply_id(): BelongsTo
    {
        return $this->belongsTo(TicketrepliesModel::class, 'ticketreply_id');
    }

      /**
     * Accessor untuk mendapatkan URL publik dari file attachment.
     */
    public function getAttachmentUrlAttribute()
    {
        if ($this->attachment) {
            // Menggunakan kolom 'attachment'
            return \Illuminate\Support\Facades\Storage::url($this->attachment);
        }
        return null;
    }
}
