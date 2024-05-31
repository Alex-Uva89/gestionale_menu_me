<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Allergen;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
 


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
            

            $allergen = Allergen::find($id);

            $validatedData = $request->validate([
                'name' => 'sometimes',
                'icon' => 'sometimes|image|mimes:png,svg|max:2048',
            ]);

            error_log(print_r($request->has('icon'), true));

            if ($request->has('icon') ) {
                $icon = $request->file('icon');
                $iconName = time() . '.' . $icon->getClientOriginalExtension();
                $iconPath = $icon->storeAs('icons', $iconName, 'public');
                $validatedData['icon'] = $iconPath;
            }

            if ($request->has('name')) {
                $validatedData['name'] = $request->name;
            }

            $allergen->fill($validatedData);
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