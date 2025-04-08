<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class DrinkController extends Controller
{
    public function getDrinks() {
        $drinks = Drink::where('is_active', 1)->get();
        return response()->json($drinks, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'instructions' => 'nullable',
            'image' => 'nullable',
            'color' => 'nullable',
            'degrees' => 'nullable',
            'origin' => 'nullable',
            'production_method' => 'nullable',
            'flavour' => 'nullable',
            'category_id' => 'nullable',
            'venue_id' => 'nullable'
        ]);
    
        $item = new Drink();
        $item->name = $validated['name'];
        $item->description = $validated['description'];
        $item->price = $validated['price'];
        $item->instructions = $validated['instructions'];
        $item->color = $validated['color'];
        $item->degrees = $validated['degrees'];
        $item->origin = $validated['origin'];
        $item->production_method = $validated['production_method'];
        $item->flavour = $validated['flavour'];
        $item->category_id = $validated['category_id'];
        $item->venue_id = $validated['venue_id'];
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/storage');
                $image->move($destinationPath, $imageName);
                $item->image = $imageName;
            } else {
                return response()->json(['error' => 'Il caricamento del file non è riuscito.'], 400);
            }
        } else {
            $item->image = $validated['image'];
        }
    
        try {
            return DB::transaction(function () use ($item) {
                if (!$item->save()) {
                    throw new \Exception('Errore nel salvataggio dell\'item');
                }
                Log::info('Item salvato correttamente');
                return response()->json($item, 201);
            });
        } catch (\Exception $e) {
            Log::error('Errore durante il salvataggio dell\'item: ' . $e->getMessage());
        
            return response()->json([
                'error' => 'Errore interno del server',
                'message' => $e->getMessage()
            ], 202);
        }
    }

    public function update(Request $request, $id, Response $response)
    {
        $drink = Drink::find($id);

        if ($request->has('name')) {
            $drink->name = request('name');
        }
        if ($request->has('description')) {
            $drink->description = request('description');
        }
        if ($request->has('price')) {
            $drink->price = request('price');
        }

        if ($request->has('instructions')) {
            $drink->instructions = request('instructions');
        }

        if ($request->has('color')) {
            $drink->color = request('color');
        }

        if ($request->has('degrees')) {
            $drink->degrees = request('degrees');
        }

        if ($request->has('origin')) {
            $drink->origin = request('origin');
        }

        if ($request->has('production_method')) {
            $drink->production_method = request('production_method');
        }

        if ($request->has('flavour')) {
            $drink->flavour = request('flavour');
        }

        if ($request->has('category_id')) {
            $drink->category_id = request('category_id');
        }
        if ($request->has('venue_id')) {
            $drink->venue_id = request('venue_id');
        }

        if ($request->has('is_active')) {
            $drink->is_active = request('is_active');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/storage');
                $image->move($destinationPath, $imageName);
                $drink->image = $imageName;
            } else {
                return response()->json(['error' => 'Il caricamento del file non è riuscito.'], 400);
            }
        }

        $drink->save();

        return response()->json($drink, 201);
    }

    public function destroyByCategory($categoryId)
    {
        // $affectedRows = Dish::where('category_id', $categoryId)
        //                     ->update(['is_orphan' => true]);

        // return response()->json([
        //     'success' => $affectedRows > 0 ? 'Dishes marked as orphans' : 'No dishes found',
        // ], 200);

        // try {
        //     return DB::transaction(function () use ($item) {
        //         if (!$item->save()) {
        //             throw new \Exception('Errore nel salvataggio dell\'item');
        //         }
        //         Log::info('Item salvato correttamente');
        //         return response()->json($item, 201);
        //     });
        // } catch (\Exception $e) {
        //     Log::error('Errore durante il salvataggio dell\'item: ' . $e->getMessage());
        
        //     return response()->json([
        //         'error' => 'Errore interno del server',
        //         'message' => $e->getMessage()
        //     ], 202);
        // }

        // rendiamo orfani tutti i piatti di una categoria che viene cancellata
        try {
            return DB::transaction(function () use ($categoryId) {
                // Recupera tutti i piatti per la categoria specificata
                $drinks = Drink::where('category_id', $categoryId)->get();

                // DEBUG: per testare la transazione, cancella una categoria senza piatti
                // if ($drinks->isEmpty()) {
                //     throw new \Exception('Nessun piatto trovato per questa categoria');
                // }

                // Aggiorna i piatti segnandoli come orfani
                $affectedRows = Drink::where('category_id', $categoryId)
                                    ->update(['is_orphan' => true]);

                // Verifica che il numero di righe aggiornate corrisponda al numero di piatti
                if ($affectedRows !== $drinks->count()) {
                    throw new \Exception('Il numero di piatti aggiornati non corrisponde al numero di piatti nella categoria');
                }

                // Se l'operazione è riuscita, ritorna una risposta positiva
                // Log::info('Piatti segnati come orfani con successo');
                return response()->json([
                    'success' => 'Drinks marked as orphans',
                ], 200);
            });
        } catch (\Exception $e) {
            // Log dell'errore e risposta con errore interno del server
            Log::error('Errore durante l\'operazione: ' . $e->getMessage());

            return response()->json([
                'error' => 'Errore interno del server',
                'message' => $e->getMessage()
            ], 500);
        }

        $categoryToDelete = Category::find($categoryId);

            if ($categoryToDelete) {
                $categoryToDelete->delete();
                return response()->json(['message' => 'Category deleted successfully']);
            } else {
                return response()->json(['message' => 'Category not found'], 404);
            }

        }

    public function destroy($id)
    {
        $item = Drink::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'item deleted successfully']);
        } else {
            return response()->json(['message' => 'Drink not found'], 404);
        }

        return response()->json(['success' => 'avoja'], 200);
    }
}