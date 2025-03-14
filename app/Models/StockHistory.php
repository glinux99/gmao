<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;
    protected $fillable=[
        "demandeur_id",
        "reference_id",
        "entry_id",
        "quantity",
        'category_id',
        'type',
        "quantity_restante",
        "etat",
        "is_remise",
        "updated_at"
    ];

    public function demandeur(){
        return $this->hasOne(User::class, 'id', 'demandeur_id');
    }
    public function reference(){
        return $this->hasOne(User::class, 'id', 'reference_id');
    }
    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id')->with('unity');
    }
    public function entry(){
        return $this->hasOne(Entry ::class, 'id','id')->with("stockhistory");
    }
}
