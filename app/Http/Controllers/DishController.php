<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    private $supabaseUrl;
    private $supabaseKey;
    private $bucketName;

    public function __construct()
    {
        $this->supabaseUrl = env('SUPABASE_URL');
        $this->supabaseKey = env('SUPABASE_KEY');
        $this->bucketName = 'images_menu'; // Nome del tuo bucket
    }

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dish = new Dish();
        $dish->name = $validated['name'];
        $dish->description = $validated['description'] ?? '';
        $dish->price = $validated['price'];
        $dish->category_id = $validated['category_id'];
        $dish->venue_id = $validated['venue_id'];

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadToSupabase($request->file('image'));
            if ($imagePath) {
                $dish->image = $imagePath;
            } else {
                return response()->json(['error' => 'Impossibile caricare l\'immagine.'], 500);
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
            $imagePath = $this->uploadToSupabase($request->file('image'));
            if ($imagePath) {
                $dish->image = $imagePath;
            } else {
                return response()->json(['error' => 'Impossibile caricare l\'immagine.'], 500);
            }
        }

        $dish->save();

        return response()->json($dish, 200);
    }

    private function uploadToSupabase($image)
    {
        $imagePath = 'images_menu/' . uniqid() . '.' . $image->getClientOriginalExtension();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => $image->getMimeType(),
        ])->attach('file', file_get_contents($image->getRealPath()), $imagePath)
          ->post($this->supabaseUrl . '/storage/v1/object/' . $this->bucketName . '/' . $imagePath);

        if ($response->successful()) {
            return $this->supabaseUrl . '/storage/v1/object/public/' . $this->bucketName . '/' . $imagePath;
        } else {
            return null;
        }
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