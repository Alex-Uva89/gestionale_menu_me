<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class DishController extends Controller
{

    public function index()
    {
        $dishes = Dish::all();
    
        // specific record if exists
        $dish_laCucina_category = Dish::all()->where('category_id', 1)->first();
        $dish_scante_category = Dish::all()->where('category_id', 2)->first();
        $dish_enoteca_category = Dish::with('allergens')->where('category_id', 3)->first();
    
        $data = [
            'dishes' => $dishes,
            'dish_laCucina_category' => $dish_laCucina_category,
            'dish_scante_category' => $dish_scante_category,
            'dish_enoteca_category' => $dish_enoteca_category,
        ];
    
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'category_id' => 'nullable',
            'venue_id' => 'nullable',
            'image' => 'nullable',
            'is_active' => 'nullable',
        ]);

        $dish = new Dish();
        $dish->name = $validated['name'];
        $dish->description = $validated['description'] ?? '';
        $dish->price = $validated['price'];
        $dish->category_id = $validated['category_id'];
        $dish->venue_id = $validated['venue_id'];
        $dish->is_active = $validated['is_active'] ?? 1;

        if ($request->has('image')) {   
            $dish->image = $request->input('image');
        }

        $dish->save();

        return response()->json($dish, 201);
    }

    public function update(Request $request, $id)
    {
        $dish = Dish::find($id);

        if (!$dish) {
            return response()->json(['error' => 'Dish not found.'], 404);
        }

        if ($request->has('name')) {
            $dish->name = $request->input('name');
        }
        if ($request->has('description')) {
            $dish->description = $request->input('description');
        }
        if ($request->has('price')) {
            $dish->price = $request->input('price');
        }
        if ($request->has('category_id')) {
            $dish->category_id = $request->input('category_id');
        }
        if ($request->has('venue_id')) {
            $dish->venue_id = $request->input('venue_id');
        }
        if ($request->has('is_active')) {
            $dish->is_active = $request->input('is_active');
        }

        if ($request->has('image')) {   
            $dish->image = $request->input('image');
        }

        $dish->save();

        return response()->json($dish, 200);
    }



    public function destroyByCategory($categoryId)
    {
        $dishes = Dish::where('category_id', $categoryId)->get();

        foreach ($dishes as $dish) {
            $dish->delete();
        }

        return response()->json(['success' => 'Dishes deleted successfully'], 200);
    }


    public function getAllergens(Dish $dish)
    {
        return response()->json($dish->allergens);
    }

    

    public function addDrinkMatch(Request $request, $id)
    {
        $dish = Dish::find($id);
        $drinkId = $request->input('drink_id');
        $dish->drinks()->attach($drinkId);
    
        return response()->json($dish, 201);
    }

    public function updateDrinkMatch(Request $request, $id)
    {
        $dish = Dish::find($id);
        $drinkId = $request->input('drink_id');
        $dish->drinks()->sync($drinkId);
        
    
        return response()->json($dish, 201);
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