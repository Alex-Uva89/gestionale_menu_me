<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Local;
use App\Models\Dish;
use App\Models\Drink;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // relationships with locals

    public function locals() 
    {
        return $this->belongsToMany(Local::class);
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
