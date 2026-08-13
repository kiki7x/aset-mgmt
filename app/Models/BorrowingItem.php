<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowingItem extends Model
{
    use HasFactory;

    protected $table = 'borrowing_items';

    protected $fillable = [
        'borrowing_id',
        'asset_id',
        'item_name',
        'original_asset_status',
    ];

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(BorrowingsModel::class, 'borrowing_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(AssetsModel::class);
    }
}
