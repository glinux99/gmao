<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceMaterial extends Model
{
    protected static $table = 'maintenance_material';
    protected $fillable=["maintenance_id", "task_id", "category_id", "quantity", 'quantity_remise'];


}
