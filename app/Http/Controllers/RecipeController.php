<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;



class RecipeController extends Controller
{
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'process' => 'required|string|max:1500',
        ]);

        $recipe = new Recipe;
        $recipe->name = $request->name;
        $recipe->process = $request->process;
        $recipe->save();
        

        return response()->json($recipe, 201);
    }

    function update(Request $request, $id)
    {
        $recipe = Recipe::find($id);
        if ($recipe) {
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'process' => 'sometimes|string|max:1500',
                'is_active' => 'sometimes|boolean',
                'dish_id' => 'sometimes|nullable|exists:dishes,id',
            ]);
    
            if ($request->has('name')) {
                $recipe->name = $request->name;
            }
            if ($request->has('process')) {
                $recipe->process = $request->process;
            }
            if ($request->has('is_active')) {
                $recipe->is_active = $request->is_active;
            }
            if ($request->has('dish_id')) {
                $recipe->dish_id = $request->dish_id;
            }

            $recipe->save();
            return response()->json($recipe, 200);
        }
        return response()->json(null, 404);
    }

    function destroy($id)
    {
        $recipe = Recipe::find($id);
        if ($recipe) {
            $recipe->delete();
            return response()->json(null, 204);
        }
        return response()->json(null, 404);
    }

}

