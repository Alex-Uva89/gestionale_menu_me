<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Category;
use App\Models\Venue;


class HomeController extends Controller
{
    public function index()
    {
        // fetch data
        $messages = Message::all(); 
        $categories = Category::all();
        $venues = Venue::all();

        $categories = Category::find(5);
        if ($categories === null) {
            die("Categoria con ID 1 non trovata.");
        }

   
        foreach ($categories->venues as $venues) {
            die($venues->pivot);
            // dd($venue->pivot->colonna_pivot_2, $venue->pivot->colonna_pivot_1); // Rimuovi questa linea se non è necessaria
        }

        // Log informazioni utili per il debug
        \Log::info('Categoria trovata:', ['categoria' => $categories]);

        // specific record
        $laCucina = Venue::where('name', 'La Cucina')->firstOrFail();
        
        // smash data
         $data = [
             'messages' => $messages,
             'categories' => $categories,
             'venues' => $venues,
             'laCucina' => $laCucina,
            // Aggiungi altri dati qui
         ];

        // return data
        return Inertia::render('Home', $data);
    }

    public function store()
    {
        // save data
        Message::create(request()->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
        ]));

        Category::create(request()->validate([
            'name' => ['required', 'max:255'],
        ]));

        Venue::create(request()->validate([
            'name' => ['required', 'max:255'],
            'color' => ['nullable', 'max:255'],
        ]));
        

        // retdirect to home
        return redirect()->route('home');
    }

    
}