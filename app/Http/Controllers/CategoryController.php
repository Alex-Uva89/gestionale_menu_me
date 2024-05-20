<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
 


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
                    'name' => 'required',
                ]);

                $category->update($validatedData);

                return redirect()->route('categories.index')
                                ->with('success', 'Categoria aggiornata con successo.');
            }

    // public function store(Request $request)
    //         {
    //             $validatedData = $request->validate([
    //                 'name' => 'required',
    //             ]);

    //             Category::create($validatedData);

    //             return redirect()->route('categories.index')
    //                             ->with('success', 'Categoria creata con successo.');
    //         }

            public function store(Request $request)
                {
                    $request->validate([
                        'name' => 'required',
                    ]);

                    $category = new Category;
                    $category->name = $request->name;
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

                


}
