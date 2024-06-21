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

    //store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'category_id' => 'nullable',
            'venue_id' => 'nullable',
            'image' => 'nullable',
        ]);
    
        $dish = new Dish();
        $dish->name = $validated['name'];
        $dish->description = $validated['description'] ?? '';
        $dish->price = $validated['price'];
        $dish->category_id = $validated['category_id'];
        $dish->venue_id = $validated['venue_id'];
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/storage');
                $image->move($destinationPath, $imageName);
                $dish->image = $imageName;
            } else {
                return response()->json(['error' => 'Il caricamento del file non è riuscito.'], 400);
            }
        } else {
            $dish->image = $validated['image'] ?? "";
        }
    
        $dish->save();
    
        return response()->json($dish, 201);
    }


    public function update(Request $request, $id, Response $response)
    {
        $dish = Dish::find($id);

        if ($request->has('name')) {
            $dish->name = request('name');
        }
        if ($request->has('description')) {
            $dish->description = request('description');
        }
        if ($request->has('price')) {
            $dish->price = request('price');
        }
        if ($request->has('category_id')) {
            $dish->category_id = request('category_id');
        }
        if ($request->has('venue_id')) {
            $dish->venue_id = request('venue_id');
        }

        if ($request->has('is_active')) {
            $dish->is_active = request('is_active');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/storage');
                $image->move($destinationPath, $imageName);
                $dish->image = $imageName;
            } else {
                return response()->json(['error' => 'Il caricamento del file non è riuscito.'], 400);
            }
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