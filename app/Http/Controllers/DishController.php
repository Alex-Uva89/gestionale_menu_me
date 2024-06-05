<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class DishController extends Controller
{
    public function index()
    {
        $dish = Dish::all();

        // specific record if exists
        $dish_laCucina_category = Dish::all()->where('category_id', 1)->firstOrFail();
        $dish_scante_category = Dish::all()->where('category_id', 2)->firstOrFail();
        $dish_enoteca_category = Dish::all()->where('category_id', 3)->firstOrFail();

        dd($dish_laCucina_category, $dish_scante_category, $dish_enoteca_category);

        $data = [
            'dish' => $dish,
            'dish_laCucina_category' => $dish_laCucina_category,
            'dish_scante_category' => $dish_scante_category,
            'dish_enoteca_category' => $dish_enoteca_category,
        ];

        return Inertia::render('Dish', $data);
    }

    //store
    public function store()
{
    $dish = new Dish();
    $dish->name = request('name');
    $dish->description = request('description');
    $dish->price = request('price');
    $dish->category_id = request('category_id');
    $dish->venue_id = request('venue_id');

    if (request()->has('image')) {
        $dish->image = request('image');
    }

    $dish->save();

    return response()->json($dish, 201);
}

    public function destroyByCategory($categoryId)
    {
        $dishes = Dish::where('category_id', $categoryId)->get();

        foreach ($dishes as $dish) {
            $dish->delete();
        }

        return response()->json(['success' => 'Dishes deleted successfully'], 200);
    }

    // public function show($id)
    // {
    //     $dish = Dish::where('category_id', $id)->get();

    //     if (!$dish) {
    //         return response()->json(['message' => 'Dish not found GET'], 404);
    //     }

    //     dd($dish);

    //     return response()->json($dish);
    // }

    public function getAllergens(Dish $dish)
    {
        return response()->json($dish->allergens);
    }

    public function destroy($id)
    {
        $dish = Dish::find($id);

        if ($dish) {
            $dish->delete();
            return response()->json(['message' => 'dish deleted successfully']);
        } else {
            return response()->json(['message' => 'Dish not found'], 404);
        }

        return response()->json(['success' => 'avoja'], 200);
    }
   
}