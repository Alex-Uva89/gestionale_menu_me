<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\Drink;


class CategoryController extends Controller
{

    public function index(): Response
        {
            $categories = Category::all();

            return Inertia::render('Home', [
                'categories' => $categories,
            ]);
        }

    public function show(Category $categories): Response
            {
                return Inertia::render('Home', [
                    'categories' => $categories,
                ]);
            }

            public function update(Request $request, $id)
            {
                $category = Category::findOrFail($id);
            
                $validatedData = $request->validate([
                    'name' => 'sometimes|required',
                    'is_active' => 'sometimes|boolean',
                ]);
            
                $category->update($validatedData);
            
                return response()->json($category, 200);
            }

            public function store(Request $request)
                {
                    $request->validate([
                        'name' => 'required',
                        'is_drink' => 'required|boolean',
                    ]);

                    $category = new Category;
                    $category->name = $request->name;
                    $category->is_drink = $request->is_drink;
                    $category->save();

                    return response()->json($category, 201);
                }

                public function destroy($id)
                {
                    $category = Category::find($id);
                
                    if ($category) {
                        $category->delete();
                        return response()->json(['message' => 'Category deleted successfully']);
                    } else {
                        return response()->json(['message' => 'Category not found'], 404);
                    }
                }

                public function addDrink($id) {
                    $category = Category::find($id);
                    $drink_id = request('drink_id');
                    $drink = Drink::find($drink_id);

                    if ($category && $drink) {
                        $category->drinks()->attach($drink);
                        return response()->json(['message' => 'Drink added to category successfully'], 200);
                    } else {
                        return response()->json(['message' => 'Category or Drink not found'], 404);
                    }
                }

                
            

                


}
