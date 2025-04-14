<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    protected $fillable=['title', 'path', 'description'];
    public function document_maintenance_tasks(): HasMany
    {
        return $this->hasMany(DocumentMaintenanceTask::class, 'document_id')->with('task', 'maintenance');
    }
}
