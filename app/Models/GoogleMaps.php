<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleMaps extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone',
        'code_rm',
        'client_number',
        'last_name',
        'first_name',
        'phone',
        'commercial_agent_name',
        'connection_type',
        'rate',
        'latitude',
        'longitude',
        'installation_type',
        'days',
        'payment_date',
        'need_small_pole',
        'pole',
    ];
}
