<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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
            'instructions' => 'nullable', // corrected name
            'image' => 'nullable',
            'color' => 'nullable',
            'degrees' => 'nullable',
            'origin' => 'nullable',
            'production_method' => 'nullable',
            'flavour' => 'nullable',
            'grape_variety' => 'nullable',
            'producer' => 'nullable',
            'denomination' => 'nullable',
            'vintage' => 'nullable',
            'breeding_method' => 'nullable',
            'format' => 'nullable',
            'serving_temperature' => 'nullable',
            'nose' => 'nullable',
            'certifications' => 'nullable',
            // 'color_fr' => 'nullable',
            // 'color_en' => 'nullable',
            // 'origin_fr' => 'nullable',
            // 'origin_en' => 'nullable',
            // 'production_method_fr' => 'nullable',
            // 'production_method_en' => 'nullable',
            // 'flavour_fr' => 'nullable',
            // 'flavour_en' => 'nullable',
            // 'breeding_method_fr' => 'nullable',
            // 'breeding_method_en' => 'nullable',
            // 'nose_fr' => 'nullable',
            // 'nose_en' => 'nullable',
            'is_active' => 'nullable',
            'category_id' => 'nullable',
            'venue_id' => 'nullable',
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
            $drink->grape_variety = $validated['grape_variety'] ?? '';
            $drink->producer = $validated['producer'] ?? '';
            $drink->denomination = $validated['denomination'] ?? '';
            $drink->vintage = !empty($validated['vintage']) ? $validated['vintage'] : null;
            $drink->breeding_method = $validated['breeding_method'] ?? '';
            $drink->format = $validated['format'] ?? '';
            $drink->serving_temperature = $validated['serving_temperature'] ?? '';
            $drink->nose = $validated['nose'] ?? '';
            $drink->certifications = $validated['certifications'] ?? '';
            $drink->is_active = $validated['is_active'] ?? 1;
            $drink->category_id = $validated['category_id'];
            $drink->venue_id = $validated['venue_id'];

            if ($request->has('image')) {
                $drink->image = $request->input('image');
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

        if ($request->has('grape_variety')) {
            $drink->grape_variety = request('grape_variety');
        }

        if ($request->has('producer')) {
            $drink->producer = request('producer');
        }

        if ($request->has('denomination')) {
            $drink->denomination = request('denomination');
        }

        if ($request->has('vintage')) {
            $drink->vintage = request('vintage');
        }

        if ($request->has('breeding_method')) {
            $drink->breeding_method = request('breeding_method');
        }

        if ($request->has('format')) {
            $drink->format = request('format');
        }

        if ($request->has('serving_temperature')) {
            $drink->serving_temperature = request('serving_temperature');
        }

        if ($request->has('nose')) {
            $drink->nose = request('nose');
        }

        if ($request->has('certifications')) {
            $drink->certifications = request('certifications');
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

        if ($request->has('image')) {   
            $drink->image = $request->input('image');
        }

        if ($request->has('color_fr')) {
            $drink->color_fr = $request->input('color_fr');
        }

        if ($request->has('color_en')) {
            $drink->color_en = $request->input('color_en');
        }

        if ($request->has('origin_fr')) {
            $drink->origin_fr = $request->input('origin_fr');
        }

        if ($request->has('origin_en')) {
            $drink->origin_en = $request->input('origin_en');
        }

        if ($request->has('production_method_fr')) {
            $drink->production_method_fr = $request->input('production_method_fr');
        }

        if ($request->has('production_method_en')) {
            $drink->production_method_en = $request->input('production_method_en');
        }

        if ($request->has('flavour_fr')) {
            $drink->flavour_fr = $request->input('flavour_fr');
        }

        if ($request->has('flavour_en')) {
            $drink->flavour_en = $request->input('flavour_en');
        }

        if ($request->has('breeding_method_fr')) {
            $drink->breeding_method_fr = $request->input('breeding_method_fr');
        }

        if ($request->has('breeding_method_en')) {
            $drink->breeding_method_en = $request->input('breeding_method_en');
        }

        if ($request->has('nose_fr')) {
            $drink->nose_fr = $request->input('nose_fr');
        }

        if ($request->has('nose_en')) {
            $drink->nose_en = $request->input('nose_en');
        }

        $drink->save();

        return response()->json($drink, 201);
    }

    public function deleteByCategory(Request $request) {
        $categoryId = $request->query('category_id');
        Drink::where('category_id', $categoryId)->delete();
        return response()->json(null, 204);
    }

    public function updateByCategory(Request $request) {
        $categoryId = $request->query('category_id');
        $status = $request->input('is_active');
    
        // Verifica che i dati siano validi
        if (is_null($categoryId) || is_null($status)) {
            return response()->json(['error' => 'Invalid input', 'category_id' => $categoryId, 'is_active' => $status], 400);
        }
    
        // Trova tutti i drink con il category_id specificato e aggiorna il campo is_active
        Drink::where('category_id', $categoryId)->update(['is_active' => $status]);
    
        // Recupera i drink aggiornati per restituirli nella risposta
        $drinks = Drink::where('category_id', $categoryId)->get();
    
        return response()->json($drinks, 200);
    }
    
}