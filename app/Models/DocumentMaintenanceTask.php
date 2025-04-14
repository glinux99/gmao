<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentMaintenanceTask extends Model
{
    //
    protected $fillable=['maintenance_id', 'task_id', 'document_id'];
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class, 'maintenance_id');
    }
}
