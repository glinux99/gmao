<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'work_order',
        'nbre_tacherons',
        'materiels',
        'man_hours',
        'maintenance_cost',
        'start_date',
        'end_date',
        'description',
        'status',
        'user_id',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technicians()
    {
        return $this->belongsToMany(User::class, 'maintenance_techniciens', 'maintenance_id', 'technicien_id');
    }
}
