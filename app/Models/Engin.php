<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Engin extends Model
{
    //
    protected $fillable=['name', 'description', 'status', 'region_id', 'user_id', 'matricule'];
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
            }
            public function engin_details(){
                    return $this->hasMany(EnginDetails ::class, 'engin_id');
            }
}
