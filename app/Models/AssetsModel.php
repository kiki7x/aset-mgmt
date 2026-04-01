<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetsModel extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'classification_id',
        'category_id',
        'admin_id',
        'client_id',
        'user_id',
        'manufacturer_id',
        'model_id',
        'supplier_id',
        'status_id',
        'purchase_date',
        'warranty_months',
        'tag',
        'name',
        'serial',
        'notes',
        'location_id',
        'customfields',
        'qrvalue',
    ];

    // fungsi search
    public function scopeSearch($query, $value)
    {
        $query->where('name', 'LIKE', "%{$value}%")
        ->orWhere('serial', 'LIKE', "%{$value}%");
    }

    // fungsi membuat tag incremental berdasarkan classification


    public function classification(): BelongsTo
    {
        return $this->belongsTo(AssetclassificationsModel::class);
    }
    // relasi ke model assetcategories
    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetcategoriesModel::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientsModel::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(ManufacturersModel::class);
    }

    public function model()
    {
        return $this->belongsTo(ModelsModel::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(SuppliersModel::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(LabelsModel::class, 'status_id', 'id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationsModel::class);
    }

    public function maintenances_schedule()
    {
        return $this->hasMany(Maintenances_scheduleModel::class);
    }

}
