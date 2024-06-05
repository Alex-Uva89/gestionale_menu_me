<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Venue;
use App\Models\Category;
use App\Models\Allergen;
use App\Models\Ingredient;
use App\Models\Dish;
use App\Models\Winery;
use App\Models\Vineyard;

class Drink extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image','price', 'description', 'instructions', 'degrees','origin'];

    public function venues()
    {
        return $this->belongsToMany(Venue::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class);
    }

    public function allergens()
    {
        return $this->belongsToMany(Allergen::class);
    }

    public function wineries()
    {
        return $this->belongsToMany(Winery::class);
    }

    public function vineyards()
    {
        return $this->belongsToMany(Vineyard::class);
    }
}
