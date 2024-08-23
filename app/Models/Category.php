<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Venue;
use App\Models\Dish;
use App\Models\Drink;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','venue_id','category_id','is_active','is_special','name_en','name_fr'];

    // relationships with venues

    public function venues() 
    {
        return $this->belongsToMany(Venue::class);
    }

    public function dishes() 
    {
        return $this->hasMany(Dish::class);
    }

    public function drinks() 
    {
        return $this->hasMany(Drink::class);
    }
}
