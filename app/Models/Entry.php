<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;
    protected $fillable=[
        "caracteristique",
        "description",
        "quantity",
        "category_id",
        "quantity_restante",
        "etat",
    ];
    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id')->with('unity');
    }
    public function stockhistory(){
        return $this->hasOne(StockHistory::class, 'entry_id', "id")->with('demandeur');
    }
}
