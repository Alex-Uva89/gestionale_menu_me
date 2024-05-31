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

            dd($allergens);

            return Inertia::render('Home', [
                'allergens' => $allergens,
            ]);
        }

    public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'icon' => 'required|image|mimes:png,svg|max:2048',
            ]);

            $iconPath = $request->file('icon')->store('allergens', 'public');

            $allergen = new Allergen;
            $allergen->name = $request->name;
            $allergen->icon = $iconPath;
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
}