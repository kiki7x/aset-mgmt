<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BorrowingsModel extends Model
{
    use HasFactory;

    protected $table = 'borrowings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type',
        'location_id',
        'asset_id',
        'user_id',
        'borrower_name',
        'borrower_nip',
        'borrower_unit',
        'borrow_start',
        'borrow_end',
        'return_date',
        'purpose',
        'status',
        'borrower_photo',
        'return_photo',
        'original_asset_status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'borrow_start' => 'datetime',
        'borrow_end' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationsModel::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(AssetsModel::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BorrowingItem::class, 'borrowing_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
