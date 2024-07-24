<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Allergen;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AllergenController extends Controller
{


    
    public function index(): Response
        {
            $allergens = Allergen::all();

            // dd($allergens);

            return Inertia::render('Home', [
                'allergens' => $allergens,
            ]);
        }

        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'icon' => 'required|url', 
            ]);
        
            $allergen = new Allergen;
            $allergen->name = $request->name;
            $allergen->icon = $request->icon;
            $allergen->save();
        
            return response()->json($allergen, 201);
        }



    
        public function update(Request $request, $id)
        {
            $allergen = Allergen::findOrFail($id);

            $request->validate([
                'name' => 'sometimes|string|max:255',
                'icon' => 'sometimes|image|mimes:png,svg|max:2048',
                'is_active' => 'sometimes|boolean',
            ]);

            
            if ($request->has('name')) {
                $allergen->name = $request->name;                
            }

            if ($request->hasFile('icon')) {
                Storage::disk('public')->delete($allergen->icon);
                $iconPath = $request->file('icon')->store('allergens', 'public');
                $allergen->icon = $iconPath;
            }

            if ($request->has('is_active')) {
                $allergen->is_active = $request->is_active;
            }

            $allergen->save();

            return response()->json($allergen, 200);
        }
        
    


    

    public function destroy($id)
        {
            $allergen = Allergen::find($id);

            if ($allergen) {
                $allergen->delete();
                return response()->json(['message' => 'Allergen deleted successfully']);
            } else {
                return response()->json(['message' => 'Allergen not found'], 404);
            }

            return response()->json(null, 204);
        }

    public function attachDishes(Request $request, $id)
        {
            $allergen = Allergen::findOrFail($id);
        
            $request->validate([
                'dish_id' => 'required|integer',
            ]);
        
            $allergen->dishes()->syncWithoutDetaching([$request->dish_id]);
        
            return response()->json($allergen->dishes, 200);
        }


    public function detachDish($allergenId, $dishId)
        {
            $allergen = Allergen::findOrFail($allergenId);

            $allergen->dishes()->detach($dishId);

            return response()->json($allergen->dishes, 200);
        }

        public function attachDrinks(Request $request, $id)
        {
            $allergen = Allergen::findOrFail($id);
        
            $request->validate([
                'drink_id' => 'required|integer',
            ]);
        
            $allergen->drinks()->syncWithoutDetaching([$request->drink_id]);
        
            return response()->json($allergen->drinks, 200);
        }

        public function detachDrink($allergenId, $drinkId)
        {
            $allergen = Allergen::findOrFail($allergenId);

            $allergen->drinks()->detach($drinkId);

            return response()->json($allergen->drinks, 200);
        }
}