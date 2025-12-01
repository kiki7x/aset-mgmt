<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Maintenances_scheduleModel extends Model
{

    use HasFactory;
    protected $table = 'maintenances_schedule';
    protected $primaryKey = 'id';
    protected $fillable = [
        'asset_id',
        'name', // nama pemeliharaan berupa 'Ganti Oli Mesin', 'Pembersihan', dll
        'frequency',
        'old_date',
        'next_date',
        'status',
        'customfields'
    ];

    public function asset()
    {
        return $this->belongsTo(AssetsModel::class, 'asset_id');
    }
}
