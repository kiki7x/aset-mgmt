<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilesModel extends Model
{
    use HasFactory;
    protected $table = 'files';
    protected $primaryKey = 'id';
    protected $fillable = [
        'client_id',
        'project_id',
        'asset_id',
        'ticketreply_id',
        'name',
        'file',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(AssetsModel::class, 'asset_id');
    }
}
