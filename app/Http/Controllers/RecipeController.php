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
                'name' => 'required|string|max:255',
                'process' => 'required|string|max:1500',
            ]);

            $recipe->name = $request->name;
            $recipe->process = $request->process;
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

