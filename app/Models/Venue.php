<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Drink;

class Venue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'image',
        'color',
        'address',
        'phone',
        'email',
        'icon',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'path',
    ];

    /* 
        relationships between tables
    */

    public function categories() 
    {
        return $this->belongsToMany(Category::class);
    }

    public function dishes() 
    {
        return $this->hasMany(Dish::class);
    }

    public function drinks() 
    {
        return $this->belongsToMany(Drink::class);
    }
}
