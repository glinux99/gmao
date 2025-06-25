<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'status',
        'work_order',
        'equipment_id',
        'user_id',
        'delay',
        'start_date',
        'end_date',
        'man_hours',
        // 'delay',
        'notified_at',
        'maintenance_cost',
        'nbre_tacherons',
        'price_tacherons',
        'assigned_user_id',
        'assigned_team_id',
        'frequency',
        'type',
        'region_id'
    ];
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

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
        return $this->belongsToMany(User::class, 'maintenance_technician', 'maintenance_id', 'user_id');
    }
    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'maintenance_material')->withPivot('quantity');
    }
    public function instructions(): HasMany
    {
        return $this->hasMany(Instruction::class);
    }
    public function expenses(): HasMany
    {
        return $this->hasMany(Depense::class);
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->with(['materials' => function ($query) {
                $query->select('categories.*', 'maintenance_material.quantity');
            },'owner_user','instructions','assigned_user','assigned_team','priority','project', 'engin']);
    }
    public function documents(){
        return $this->hasMany(DocumentMaintenanceTask::class)->with('document');
    }
}
