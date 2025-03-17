<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instruction extends Model
{
    use HasFactory;
     protected $fillable = [
        'task_id',
        'description',
        'response_type',
        'maintenance_id'
    ];

    // Define the relationship with the Task model
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }
}
