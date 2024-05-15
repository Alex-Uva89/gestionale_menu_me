<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Local;
use App\Models\Category;
use App\Models\Filter;
use App\Models\Allergen;
use App\Models\Ingredient;
use App\Models\Drink;
use App\Models\Recipe;

class Dish extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'image', 'price', 'description'];

    public function locals()
    {
        return $this->belongsTo(Local::class);
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

    public function pairing_drinks()
    {
        return $this->belongsToMany(Drink::class);
    }

    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }

}
