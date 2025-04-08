<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Venue;
use App\Models\Dish;
use App\Models\Drink;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['name',/*'venue_id','category_id',*/'is_active','is_special'];

    // relationships with venues

    // public function venues() 
    // {
    //     return $this->belongsToMany(Venue::class);
    // }

    public function dishes() 
    {
        return $this->hasMany(Dish::class);
    }

    public function drinks() 
    {
        return $this->hasMany(Drink::class);
    }


    /* 
    * INFO DATABASE RELATIONS
    * 
    * in db è stato creato la tabella CATEGORY_RELATIONS che mette in correlazione le tipologie categorie con le categorie
    * le tipologie potranno essere  FOOD, BEVERAGE, TRIP ecc.. e le categorie: DISH, DRINK, LOCATIONTRIP ecc..
    * 
    */
}
