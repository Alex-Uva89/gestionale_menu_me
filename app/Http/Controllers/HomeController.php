<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Recupera i dati dal database
        $messages = Message::all(); // Assumendo che Message sia il modello per i tuoi messaggi
        $categories = Category::all(); // Assumendo che Category sia il modello per le tue categorie

        // Combina i dati come necessario
        $data = [
            'messages' => $messages,
            'categories' => $categories,
            // Aggiungi altri dati qui
        ];

        // Restituisci i dati alla tua app
        return Inertia::render('Home', $data);
    }
}