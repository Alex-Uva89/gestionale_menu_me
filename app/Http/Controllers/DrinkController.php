<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;



class DrinkController extends Controller
{
    public function getDrinks() {
        $drinks = Drink::where('is_active', 1)->get();
        return response()->json($drinks, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'instructions' => 'nullable',
            'image' => 'nullable',
            'color' => 'nullable',
            'degrees' => 'nullable',
            'origin' => 'nullable',
            'production_method' => 'nullable',
            'flavour' => 'nullable',
            'category_id' => 'nullable',
            'venue_id' => 'nullable'
        ]);
    
        $drink = new Drink();
        $drink->name = $validated['name'];
        $drink->description = $validated['description'] ?? '';
        $drink->price = $validated['price'];
        $drink->instructions = $validated['instructions'] ?? '';
        $drink->color = $validated['color'] ?? '';
        $drink->degrees = $validated['degrees'] ?? '';
        $drink->origin = $validated['origin'] ?? '';
        $drink->production_method = $validated['production_method'] ?? '';
        $drink->flavour = $validated['flavour'] ?? '';
        $drink->category_id = $validated['category_id'];
        $drink->venue_id = $validated['venue_id'];
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/storage');
                $image->move($destinationPath, $imageName);
                $drink->image = $imageName;
            } else {
                return response()->json(['error' => 'Il caricamento del file non è riuscito.'], 400);
            }
        } else {
            $drink->image = $validated['image'] ?? "";
        }
    
        $drink->save();
    
        return response()->json($drink, 201);
    }

    public function update(Request $request, $id, Response $response)
    {
        $drink = Drink::find($id);

        if ($request->has('name')) {
            $drink->name = request('name');
        }
        if ($request->has('description')) {
            $drink->description = request('description');
        }
        if ($request->has('price')) {
            $drink->price = request('price');
        }

        if ($request->has('instructions')) {
            $drink->instructions = request('instructions');
        }

        if ($request->has('color')) {
            $drink->color = request('color');
        }

        if ($request->has('degrees')) {
            $drink->degrees = request('degrees');
        }

        if ($request->has('origin')) {
            $drink->origin = request('origin');
        }

        if ($request->has('production_method')) {
            $drink->production_method = request('production_method');
        }

        if ($request->has('flavour')) {
            $drink->flavour = request('flavour');
        }

        if ($request->has('category_id')) {
            $drink->category_id = request('category_id');
        }
        if ($request->has('venue_id')) {
            $drink->venue_id = request('venue_id');
        }

        if ($request->has('is_active')) {
            $drink->is_active = request('is_active');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/storage');
                $image->move($destinationPath, $imageName);
                $drink->image = $imageName;
            } else {
                return response()->json(['error' => 'Il caricamento del file non è riuscito.'], 400);
            }
        }

        $drink->save();

        return response()->json($drink, 201);
    }

    public function deleteByCategory(Request $request) {
        $categoryId = $request->query('category_id');
        Drink::where('category_id', $categoryId)->delete();
        return response()->json(null, 204);
    }
}