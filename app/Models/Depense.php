<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    //
    protected $fillable=['maintenance_id', 'title', 'amount', 'readonly','nombre','price_unity'];
}
