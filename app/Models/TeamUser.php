<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    use HasFactory;

    protected $table = 'team_user'; // Specify the table name explicitly

    protected $fillable = [
        'team_id',
        'user_id',
    ];
}
