<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicensecategoriesModel extends Model
{
    use HasFactory;
    protected $table = 'licensecategories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'color',
    ];

    public function scopeSearch($query, $value)
    {
       $query->where('name', 'LIKE', "%{$value}%");
    }

}
