<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceTechnicien extends Model
{

    protected $fillable=[
        'maintenance_id', 'technicien_id'
    ];

}
