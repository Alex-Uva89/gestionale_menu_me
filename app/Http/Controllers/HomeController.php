<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Category;
use App\Models\Venue;
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

        // dd($category_laCucina->toArray());

        // smash data
         $data = [
             'messages' => $messages,
             'categories' => $categories,
             'venues' => $venues,
             'laCucina' => $laCucina,
             'category_laCucina' => $category_laCucina->toArray(),
             'category_scante' => $category_scante->toArray(),
             'category_enoteca' => $category_enoteca,
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

        

        // retdirect to home
        return redirect()->route('home');
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