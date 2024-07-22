<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    function uploadImageToSupabase($file) {
        $supabaseUrl = 'https://quoufacprncabkhqbdpm.supabase.co'; 
        $bucketName = 'images_menu'; 
        $apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InF1b3VmYWNwcm5jYWJraHFiZHBtIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjEzOTExMjQsImV4cCI6MjAzNjk2NzEyNH0.xSLnJMTa80QxJIhNhEmiCKeBzvZYEu_CR8d_fHZQPOo'; 
    
        // Ottieni il nome del file
        $fileName = time() . '-' . $file->getClientOriginalName();
        $fileContent = file_get_contents($file->getPathname());

        // Carica il file su Supabase
        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/octet-stream'
        ])->put("$supabaseUrl/storage/v1/object/$bucketName/$fileName", $fileContent);

        // Stampa il corpo della risposta per il debug
        logger()->info('Supabase Response:', ['response' => $response->body()]);

        if ($response->successful()) {
            // Ottieni l'URL pubblico
            $publicUrl = "$supabaseUrl/storage/v1/object/public/$bucketName/$fileName";
            return $publicUrl;
        } else {
            // Gestisci l'errore
            throw new \Exception('Failed to upload image: ' . $response->body());
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'category_id' => 'nullable',
            'venue_id' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dish = new Dish();
        $dish->name = $validated['name'];
        $dish->description = $validated['description'] ?? '';
        $dish->price = $validated['price'];
        $dish->category_id = $validated['category_id'];
        $dish->venue_id = $validated['venue_id'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            try {
                $imageUrl = uploadImageToSupabase($image);
                $dish->image = $imageUrl;
            } catch (\Exception $e) {
                return response()->json(['error' => 'Image upload failed: ' . $e->getMessage()], 500);
            }
        } else {
            $dish->image = $validated['image'] ?? "";
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                try {
                    $imageUrl = uploadImageToSupabase($image);
                    $dish->image = $imageUrl;
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Image upload failed: ' . $e->getMessage()], 500);
                }
            } else {
                return response()->json(['error' => 'Il caricamento del file non è riuscito.'], 400);
            }
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