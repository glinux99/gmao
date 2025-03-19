<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory; // Added SoftDeletes trait

    protected $fillable = [
        'priority_id',
        'status',
        'complete',
        'user_id', // This is the creator of the task
        'owner', // This is the owner of the task
        'task_id', // This is the parent task ID (for subtasks)
        'assigned_date',
        'start_date',
        'due_date',
        'delay',
        'description',
        'project_id',
        'type',
        'comments',
        "tools",
        'assigned_user_id', // This is the user assigned to the task
        'assigned_team_id', // This is the team assigned to the task
    ];

    /**
     * Get the user that created the task.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the owner of the task.
     *
     * @return BelongsTo
     */
    public function owner_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner');
    }

    /**
     * Get the parent task.
     *
     * @return BelongsTo
     */
    public function parentTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * Get the subtasks of this task.
     *
     * @return HasMany
     */
    public function subTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'task_id');
    }

    /**
     * Get the project that owns the Task
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the instructions for the task.
     *
     * @return HasMany
     */
    public function instructions(): HasMany
    {
        return $this->hasMany(Instruction::class);
    }

    /**
     * Get the user assigned to the task.
     *
     * @return BelongsTo
     */
    public function assigned_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    /**
     * Get the team assigned to the task.
     *
     * @return BelongsTo
     */
    public function assigned_team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'assigned_team_id');
    }
    public function priority(): HasOne
    {
        return $this->hasone(Priority::class, 'id', 'priority_id');
    }
}
