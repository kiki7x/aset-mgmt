<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BuildingsModel extends Model
{
    use HasFactory;
    protected $table = 'buildings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'client_id',
        'name',
    ];

    public function locations()
    {
        return $this->hasMany(LocationsModel::class, 'building_id', 'id');
    }

}
