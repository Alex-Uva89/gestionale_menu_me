<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Venue;
use App\Models\Category;
use App\Models\Allergen;
use App\Models\Ingredient;
use App\Models\Drink;
use App\Models\Recipe;

class Dish extends Model
{
    use HasFactory;


    protected $fillable = ['name','description','price','image','is_active','venue_id','category_id'];

    public function venues()
    {
        return $this->belongsTo(Venue::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

     public function allergens()
    {
        return $this->belongsToMany(Allergen::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    public function drinks()
    {
        return $this->belongsToMany(Drink::class);
    }

    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }

}
