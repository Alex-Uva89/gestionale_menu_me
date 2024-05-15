<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Drink;

class Vineyard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function drinks()
    {
        return $this->belongsToMany(Drink::class);
    }
}
