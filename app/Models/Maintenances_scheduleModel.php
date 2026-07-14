<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Maintenances_scheduleModel extends Model
{

    use HasFactory;
    protected $table = 'maintenances_schedule';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_id',
        'name', // nama pemeliharaan berupa 'Ganti Oli Mesin', 'Pembersihan', dll
        'start',
        'end',
        'frequency',
        'reminder',
        'last_reminder_sent_at',
        'status',
        'customfields'
    ];

    public function asset()
    {
        return $this->belongsTo(AssetsModel::class, 'asset_id');
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(MaintenancesModel::class, 'maintenance_schedule_id');
    }
}
