<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LicensesModel extends Model
{
    use HasFactory;
    protected $table = 'licenses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status_id',
        'category_id',
        'supplier_id',
        'seats',
        'tag',
        'name',
        'serial',
        'notes',
    ];

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'LIKE', "%{$value}%")
        ->orWhere('tag', 'LIKE', "%{$value}%")
        ->orWhere('serial', 'LIKE', "%{$value}%");
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(LabelsModel::class, 'status_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LicensecategoriesModel::class, 'category_id', 'id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(SuppliersModel::class, 'supplier_id', 'id');
    }

    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(AssetsModel::class, 'licenses_assets', 'license_id', 'asset_id')
            ->withTimestamps();
    }

}
