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

    protected $fillable = ['name','venue_id','category_id','is_active'];

    // relationships with venues

    public function venues() 
    {
        return $this->belongsToMany(Venue::class)->withPivot('category_id','venue_id');
    }

    public function dishes() 
    {
        return $this->hasMany(Dish::class)->withPivot('category_id','dish_id');
    }

    public function drinks() 
    {
        return $this->hasMany(Drink::class);
    }
}
