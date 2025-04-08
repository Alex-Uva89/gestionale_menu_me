<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'price', 'image', 'is_active', 'venue_id', 'category_id', 
        'instructions', 'degrees', 'origin'
    ];


    // Relazioni con Venue e Category
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relazioni comuni con Allergen e Ingredient
    public function allergens()
    {
        return $this->belongsToMany(Allergen::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    // Relazione opzionale con Recipe (solo per i piatti)
    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }

    // Relazione opzionale con Winery e Vineyard (solo per i drink)
    public function wineries()
    {
        return $this->belongsToMany(Winery::class);
    }

    public function vineyards()
    {
        return $this->belongsToMany(Vineyard::class);
    }
}
