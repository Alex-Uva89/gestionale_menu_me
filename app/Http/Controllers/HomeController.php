<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Category;
use App\Models\Venue;
use App\Models\Dish;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // fetch data
        $messages = Message::all(); 
        $categories = Category::all();
        $venues = Venue::all();

        

        // specific record
        $laCucina = Venue::where('name', 'La Cucina')->firstOrFail();
        $scante = Venue::where('name', "'Scante")->firstOrFail();
        $enoteca = Venue::where('name', 'Enoteca')->firstOrFail();
        
        //devo rintracciare tutte le categorie presenti nella table category_venue che hanno come venue_id il valore di $laCucina->id
        
        $category_laCucina = Category::whereHas('venues', function ($query) use ($laCucina) {
            $query->where('venue_id', $laCucina->id);
        })->get();

        $category_scante = Category::whereHas('venues', function ($query) use ($scante) {
            $query->where('venue_id', $scante->id);
        })->get();

        $category_enoteca = Category::whereHas('venues', function ($query) use ($enoteca) {
            $query->where('venue_id', $enoteca->id);
        })->get();

        $dish_laCucina_category = Dish::all()->where('venue_id', 1);
        $dish_scante_category = Dish::all()->where('venue_id', 2);
        $dish_enoteca_category = Dish::all()->where('venue_id', 3);

        
        // smash data
         $data = [
             'messages' => $messages,
             'categories' => $categories,
             'venues' => $venues,
             'laCucina' => $laCucina,
             'category_laCucina' => $category_laCucina->toArray(),
             'category_scante' => $category_scante->toArray(),
             'category_enoteca' => $category_enoteca,
             'dish_laCucina_category' => $dish_laCucina_category,
             'dish_scante_category' => $dish_scante_category,
             'dish_enoteca_category' => $dish_enoteca_category,
            // Aggiungi altri dati qui
         ];

        // return data
        return Inertia::render('Home', $data);
    }

    public function store(Request $request)
    {
        // save data
        Message::create(request()->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
        ]));
    
        Venue::create(request()->validate([
            'name' => ['required', 'max:255'],
            'color' => ['nullable', 'max:255'],
        ]));
    
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
        ]);
    
        $category = new Category;
        $category->name = $validatedData['name'];
        $category->save();
    
        foreach ($validatedData['venue_ids'] as $venueId) {
            $category->venues()->attach($venueId);
        }

        Dish::create(request()->validate([
            'name' => ['required', 'max:255'],
            'category_id' => ['required', 'max:255'],
        ]));

        

        // retdirect to home
        return redirect()->route('home');
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

    public function attachVenues(Request $request, $id)
                {
                    $validatedData = $request->validate([
                        'venue_id' => ['required', 'array']
                    ]);

                    $category = Category::find($id);

                    if ($category) {
                        foreach ($validatedData['venue_id'] as $venueId) {
                            $category->venues()->attach($venueId);
                        }
                    } else {
                        return response()->json(['error' => 'Category not found'], 404);
                    }
                }

    
}