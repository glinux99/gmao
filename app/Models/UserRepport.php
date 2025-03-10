<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserRepport extends Model
{
    //
    use Notifiable;
    protected $fillable=[
        'fullname', 'email', 'categories', 'id'
    ];
}
