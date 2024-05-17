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

        // dd($categories->where('name', 'Ristorante'));

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