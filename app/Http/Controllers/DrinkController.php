<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Models\Drink;

class DrinkController extends Controller
{
    public function store() {
        $drink = new Drink();
        $drink->name = request('name');
        $drink->price = request('price');
        $drink->description = request('description');
        $drink->instructions = request('instructions');
        $drink->degrees = request('degrees');
        $drink->origin = request('origin');
        $drink->color = request('color');
        $drink->production_method = request('production_method');
        $drink->flavour = request('flavour');
        $drink->category_id = request('category_id');
        $drink->venue_id = request('venue_id');
        
        if (request()->has('image')) {
            $drink->image = request('image');
        }
        
        $drink->save();
        
        return response()->json($drink, 201);
    }
}