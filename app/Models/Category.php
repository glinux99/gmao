<?php

namespace App\Models;

use Carbon\Unit;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable=[
        "designation", "unity_id", "caracteristique",
        "avatar","is_remise","description"
    ];
    public function unity()
    {
        return $this->hasOne(Unity::class, 'id', 'unity_id');
    }
}
