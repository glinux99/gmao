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
        'maintenance_id',
        'value'
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

    /**
     * Set the value attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setValueAttribute($value)
    {
        if ($this->response_type === 'checkbox') {
            $this->attributes['value'] = (bool) $value;
        } else {
            $this->attributes['value'] = $value;
        }
    }

    /**
     * Get the value attribute.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function getValueAttribute($value)
    {
        if ($this->response_type === 'checkbox') {
            return (bool) $value;
        }
        return $value;
    }
}
