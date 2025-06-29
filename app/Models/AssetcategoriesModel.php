<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AssetcategoriesModel extends Model
{
    use HasFactory;
    protected $table = 'assetcategories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'color',
        'classification_id',
    ];

    public function assets()
    {
        return $this->hasMany(AssetsModel::class);
    }

    public function scopeSearch($query, $value)
    {
       $query->where('name', 'LIKE', "%{$value}%");
    }

    public function classification()
    {
        return $this->belongsTo(AssetclassificationsModel::class);
    }

}
