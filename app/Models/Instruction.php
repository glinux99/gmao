<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use HasFactory;
     protected $fillable = [
        'task_id',
        'description',
        'response_type',
    ];

    // Define the relationship with the Task model
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
