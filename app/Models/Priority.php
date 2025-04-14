<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    //
    protected $fillable=[
        'title','value', 'color', 'is_default'
    ];
}
