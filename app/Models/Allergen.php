<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dish;
use App\Models\Drink;

class Allergen extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];

    public function dishes()
    {
        return $this->belongsToMany(Dish::class);
    }

    public function drinks()
    {
        return $this->belongsToMany(Drink::class);
    }
}
