<?php

namespace App\Models;

use Carbon\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    //
    protected $fillable=[
        "designation", "unity_id", "caracteristique",
        "avatar","is_remise","description" , "type"
    ];
    public function unity()
    {
        return $this->hasOne(Unity::class, 'id', 'unity_id');
    }
    public function materials(): HasMany
    {
        return $this->hasMany(MaintenanceMaterial::class);
    }

    public function maintenances(): BelongsToMany
    {
        return $this->belongsToMany(Maintenance::class, 'maintenance_material')->withPivot('quantity');
    }
}
