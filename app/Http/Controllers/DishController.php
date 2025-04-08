<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class DishController extends Controller
{

    public function index()
    {
        $items = Dish::all();
    
        // specific record if exists
        $dish_laCucina_category = Dish::all()->where('category_id', 1)->get();
        $dish_scante_category = Dish::all()->where('category_id', 2)->get();
        $dish_enoteca_category = Dish::with('allergens')->where('category_id', 3)->get();

        var_dump($dish_enoteca_category);
    
        $data = [
            'dishes' => $items,
            'dish_laCucina_category' => $dish_laCucina_category,
            'dish_scante_category' => $dish_scante_category,
            'dish_enoteca_category' => $dish_enoteca_category,
        ];
    
        return response()->json($data);
    }

    //store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'category_id' => 'nullable',
            'venue_id' => 'nullable',
            'image' => 'nullable',
        ]);
    
        $item = new Dish();
        $item->name = $validated['name'];
        $item->description = $validated['description'];
        $item->price = $validated['price'];
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
        
                // INFO [ come ripulire il database da valori nulli o undefined ]
                // start transaction;
                // SET SQL_SAFE_UPDATES = 0;
                // UPDATE dishes 
                // SET 
                //     image = (SELECT NULL WHERE TRIM(image) IN ('null', 'undefined', '')),
                //     description = (SELECT NULL WHERE TRIM(description) IN ('null', 'undefined', ''))
                // WHERE 
                //     TRIM(image) IN ('null', 'undefined', '') 
                //     OR TRIM(description) IN ('null', 'undefined', '');
        
                // -- verifica con una select che i dati siano stati effettivamente ripuliti
                // -- decommenta lancia questa select semparatamente (in un'altra query tab di mysql workbench) dall'update sopra e verifica che tutto sia stato ripulito nel modo giusto
                // -- select * from dishes;
        
                // -- se la select è andata a buon fine puoi fare il commit così scrivi sul database le effettive modifiche
                // -- decommenta e lancia questo separatamente
                // -- commit;
        
                // -- se invece non ha funzionato o peggio tutto è andato in malora allora fai il rollback, ti ripristina lo stato precedente all'update
                // -- decommenta e lancialo sepratamente
                // -- rollback;
        
                // -- auguri :*
        
      
    }


    public function update(Request $request, $id, Response $response)
    {
        $item = Dish::find($id);

        if ($request->has('name')) {
            $item->name = request('name');
        }
        if ($request->has('description')) {
            $item->description = request('description');
        }
        if ($request->has('price')) {
            $item->price = request('price');
        }
        if ($request->has('category_id')) {
            $item->category_id = request('category_id');
        }
        if ($request->has('venue_id')) {
            $item->venue_id = request('venue_id');
        }

        if ($request->has('is_active')) {
            $item->is_active = request('is_active');
        }

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
        }

        $item->save();

        return response()->json($item, 201);
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
                $dishes = Dish::where('category_id', $categoryId)->get();

                // DEBUG: per testare la transazione, cancella una categoria senza piatti
                // if ($dishes->isEmpty()) {
                //     throw new \Exception('Nessun piatto trovato per questa categoria');
                // }

                // Aggiorna i piatti segnandoli come orfani
                $affectedRows = Dish::where('category_id', $categoryId)
                                    ->update(['is_orphan' => true]);

                // Verifica che il numero di righe aggiornate corrisponda al numero di piatti
                if ($affectedRows !== $dishes->count()) {
                    throw new \Exception('Il numero di piatti aggiornati non corrisponde al numero di piatti nella categoria');
                }

                // Se l'operazione è riuscita, ritorna una risposta positiva
                Log::info('Piatti segnati come orfani con successo');
                return response()->json([
                    'success' => 'Dishes marked as orphans',
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



    public function getAllergens(Dish $item)
    {
        return response()->json($item->allergens);
    }

    

    public function addDrinkMatch(Request $request, $id)
    {
        $item = Dish::find($id);
        $drinkId = $request->input('drink_id');
        $item->drinks()->attach($drinkId);
    
        return response()->json($item, 201);
    }

    public function updateDrinkMatch(Request $request, $id)
    {
        $item = Dish::find($id);
        $drinkId = $request->input('drink_id');
        $item->drinks()->sync($drinkId);
        
    
        return response()->json($item, 201);
    }


    public function destroy($id)
    {
        $item = Dish::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'item deleted successfully']);
        } else {
            return response()->json(['message' => 'Dish not found'], 404);
        }

        return response()->json(['success' => 'avoja'], 200);
    }
   
}