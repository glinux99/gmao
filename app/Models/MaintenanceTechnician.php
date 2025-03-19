<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceTechnician extends Model
{
    protected static $table = 'maintenance_technician';
    protected $fillable =[
        "maintenance_id",
        "user_id",
        "created_at",
        "updated_at"
    ];
}
