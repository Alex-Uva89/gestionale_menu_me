<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Drink;
use App\Models\Dish;
use App\Models\Recipe;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name','image','description','origin'];

    public function drinks()
    {
        return $this->belongsToMany(Drink::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class);
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
