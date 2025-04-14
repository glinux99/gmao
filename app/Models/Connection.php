<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    //
    protected $fillable = [
        'opt',
        'opt_used',
        'user_id',
        'appareil',
        'ip',
        'navigator'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
