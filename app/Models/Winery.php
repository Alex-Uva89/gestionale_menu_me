<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Drink;

class Winery extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'origin', 'description', 'wine_maker'];

    public function drinks()
    {
        return $this->belongsToMany(Drink::class);
    }
}
