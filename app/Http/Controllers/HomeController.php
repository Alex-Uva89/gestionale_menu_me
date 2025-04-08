<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Category;
use App\Models\Venue;
use App\Models\Dish;
use App\Models\Allergen;
use App\Models\Drink;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\collect;



class HomeController extends Controller
{
    private function getCategory($venue)
    {
        $categories   =   Category::with(['dishes', 'drinks'])
                            ->where('venue_id', $venue->id)
                            ->get();

        // dd($venue);

        return $categories;
    }
    // private function getCategories($venues)
    // {
    //     $categories = [];
    //     foreach ($venues as $venue) {
    //         $categories[]   =   Category::with(['dishes', 'drinks'])
    //                             ->whereHas('venues', function ($query) use ($venue) {
    //                                 $query->where('venue_id', $venue->id);
    //                             })
    //                             ->get();

    //         // dd($venue);
    //     }
    //     return $categories;
    // }

    private function decodeCss(& $ref)
    {
        if (is_string($ref)) {
            $ref = json_decode($ref, true);
        }
    }

    public function index()
    {
        // fetch data
        $messages       = Message::all(); 
        // $categoriesAll  = Category::all();
        $venues         = Venue::all(); //orderBy('orderView', 'asc')->get();
        $receips        = Recipe::all();
        $drinks         = Drink::all();
        $dishes         = Dish::all();
        // $components     = Component::all(); // da ordinare per orderView
        $components     = [                 // TODO: realizzare model per i componenti 
            [
                'name'              => 'Ristoranti',
                'css'               => [
                    'bg_color' => 'none',
                    'color'    => '#fff'
                ],
                'orderView'         => 0,
                'icon'              => 'restaurant',
                'visibility'        => 1,
                'nature'            => 'venues',
                'default' => false
                // $venues TODO: da aggiungere i venues
            ],
            [
                'name' => 'Welcome',
                'css'=> [
                    'bg_color' => '#007cff',
                    'color'    => '#000'
                ],
                'orderView' => 1,
                'icon' => 'home',
                'visibility' => 1,
                'nature' => '',
                'default' => true,
                'componentName' => "Welcome",

            ],
            [
                'name' => 'Dashboard',
                'css'=> [
                    'bg_color' => '#ffbf00',
                    'color'    => '#fff'
                ],
                'orderView' => 2,
                'icon' => 'space_dashboard',
                'visibility' => 0,
                'nature' => '',
                'default' => false,
                'componentName' => 'Dashboard',
            ],
            [
                'name' => 'Preview',
                'css'=> [
                    'bg_color' => '#ffbf00',
                    'color'    => '#fff'
                ],
                'orderView' => 3,
                'icon' => 'preview',
                'visibility' => 0,
                'nature' => '',
                'default' => false,
                'componentName'=> 'Preview',

            ],
            [
                'name' => 'Allergens',
                'css'=> [
                    'bg_color' => '#ffbf00',
                    'color'    => '#fff'
                ],
                'orderView' => 4,
                'icon' => 'allergies',
                'visibility' => 1,
                'nature' => '',
                'default' => false,
                'componentName'=> 'Allergens',
            ],
            [
                'name' => 'Messagge',
                'css'=> [
                    'bg_color' => '#ffbf00',
                    'color'    => '#fff'
                ],
                'orderView' => 5,
                'icon' => 'chat',
                'visibility' => 1,
                'nature' => '',
                'default' => false,
                'componentName'=> 'Inbox',
            ],
            // [
            //     'name' => 'login',
            //     'css'=> [
            //         'bg_color' => '#ffbf00',
            //         'color'    => '#fff'
            //     ],
            //     'orderView' => 6,
            //     'icon' => 'login',
            //     'visibility' => 0,
            //     'nature' => '',
            //     'default' => false
            // ],
            
        ];

        $default_id = null;

        foreach ($components as $index => &$component) {
            if($component['default'] == true){
                $default_id = $index;
            }
            if($component['nature'] == 'venues') {
                $venues = Venue::orderBy('orderView', 'asc')->get(); // richiamiamo i venue in ordine di orderView



                // $categories         = $this->getCategories($venues);
                foreach ($venues as $venue) {
                    
                    $venue['categories']         = $this->getCategory($venue); //TODO: da spostare la logica quando viene chiamato model venue
                    // $venue['nature'] = $component['nature'];
                    // $this->decodeCss($venue->css);
                    // dd($venue);
                }
                
                $component['data']  = $venues;
                
                // dump($component); // categorie di tutti i venue
                
            } else {
                $component['data'] = null;
            }
        }
        // variables for cicle foreach
        

        // dd($components); // venues

        $allergens       = Allergen::all();
        $allergensDishes = Allergen::with('dishes')->get();
        $allergensDrinks = Allergen::with('drinks')->get();

        // smash data
        $data = [
            'messages'              => $messages,
            // 'categories'            => $categories,
            'venues'                => collect($venues)->sortBy('orderView')->values()->toArray(), // invio dati ordinati per orderView
            'drinks'                => $drinks,
            'dishes'                => $dishes,
            'receips'               => $receips,
            'allergens'             => $allergens,
            'allergensDishes'       => $allergensDishes,
            'allergensDrinks'       => $allergensDrinks,
            'components'            => $components,
            'default_id'            => $default_id,
            'category_relations'    => [
                [
                    'id'                    => 1,
                    'table_category_name'   => 'dishes',
                    'classification'        => 'FOOD',
                    'css'                   => [
                        'bg_color'  => '#007cff',
                        'color'     => '#000'
                    ],
                ],
                [
                    'id'                     => 2,
                    'table_category_name'   => 'drinks',
                    'classification'        => 'BEVERAGE',
                    'css'                   => [
                        'bg_color'  => '#ffbf00',
                        'color'     => '#fff'
                    ]
                ],
            ],

            // 'category' => $category, //->toArray(),
            // 'dish_category' => $dish_category,
            // 'drink_category' => $drink_category,
            // 'pairings' => $pairings
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
            'is_drink' => ['required', 'boolean'], 
        ]);

        $category = new Category;
        $category->name = $validatedData['name'];
        $category->is_drink = $validatedData['is_drink'];
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



































// class HomeController extends Controller
// {
//     public function index()
//     {
//         // fetch data
//         $messages = Message::all(); 
//         $categories = Category::all();
//         // $venues = Venue::all();
//         $receips = Recipe::all();
//         $drinks = Drink::all();
//         $dishes = Dish::all();
    

//         // specific record
//         $laCucina = Venue::where('name', 'La Cucina')->firstOrFail();
//         $scante = Venue::where('name', "'Scante")->firstOrFail();
//         $enoteca = Venue::where('name', 'Enoteca')->firstOrFail();

//         $venue = 
        
//         //devo rintracciare tutte le categorie presenti nella table category_venue che hanno come venue_id il valore di $laCucina->id
        
//         $category_laCucina = Category::whereHas('venues', function ($query) use ($laCucina) {
//             $query->where('venue_id', $laCucina->id);
//         })->get();

//         $category_scante = Category::whereHas('venues', function ($query) use ($scante) {
//             $query->where('venue_id', $scante->id);
//         })->get();

//         $category_enoteca = Category::with(['dishes', 'drinks'])
//             ->whereHas('venues', function ($query) use ($enoteca) {
//                 $query->where('venue_id', $enoteca->id);
//             })
//             ->get();

//         // dd($category_enoteca);

//         $dish_laCucina_category = Dish::all()->where('venue_id', 1);
//         $dish_scante_category = Dish::all()->where('venue_id', 2);
//         $dish_enoteca_category = Dish::all()->where('venue_id', 3);

//         $drink_enoteca_category = Drink::all()->where('venue_id', 3);

//         $allergens = Allergen::all();

//         $allergensDishes = Allergen::with('dishes')->get();
//         $allergensDrinks = Allergen::with('drinks')->get();

      

//         $pairings_enoteca = Dish::with('drinks')->where('venue_id', 3)->get();                        
        
//         // smash data
//          $data = [
//                 'messages' => $messages,
//                 'categories' => $categories,
//                 // 'venues' => $venues,
//                 'drinks' => $drinks,
//                 'dishes' => $dishes,
//                 'laCucina' => $laCucina,
//                 'receips' => $receips,
//                 'category_laCucina' => $category_laCucina->toArray(),
//                 'category_scante' => $category_scante->toArray(),
//                 'category_enoteca' => $category_enoteca,
//                 'dish_laCucina_category' => $dish_laCucina_category,
//                 'dish_scante_category' => $dish_scante_category,
//                 'dish_enoteca_category' => $dish_enoteca_category,
//                 'drink_enoteca_category' => $drink_enoteca_category,
//                 'allergens' => $allergens,
//                 'allergensDishes' => $allergensDishes,
//                 'allergensDrinks' => $allergensDrinks,
//                 'pairingsEnoteca' => $pairings_enoteca
//          ];


//         // return data
//         return Inertia::render('Home', $data);
//     }

//     public function store(Request $request)
//     {
//         // save data
//         Message::create(request()->validate([
//             'title' => ['required', 'max:255'],
//             'body' => ['required'],
//         ]));

//         Venue::create(request()->validate([
//             'name' => ['required', 'max:255'],
//             'color' => ['nullable', 'max:255'],
//         ]));

//         $validatedData = $request->validate([
//             'name' => ['required', 'max:255'],
//             'is_drink' => ['required', 'boolean'], 
//         ]);

//         $category = new Category;
//         $category->name = $validatedData['name'];
//         $category->is_drink = $validatedData['is_drink'];
//         $category->save();

//         foreach ($validatedData['venue_ids'] as $venueId) {
//             $category->venues()->attach($venueId);
//         }

//         Dish::create(request()->validate([
//             'name' => ['required', 'max:255'],
//             'category_id' => ['required', 'max:255'],
//         ]));

//         // retdirect to home
//         return redirect()->route('home');
//     }

//     public function destroy($id)
//         {
//             $category = Category::find($id);

//             if ($category) {
//                 $category->delete();
//                 return response()->json(['message' => 'Category deleted successfully']);
//             } else {
//                 return response()->json(['message' => 'Category not found'], 404);
//             }
//         }

//     public function attachVenues(Request $request, $id)
//                 {
                    
//                     $validatedData = $request->validate([
//                         'venue_id' => ['required', 'array']
//                     ]);
                    
//                     $category = Category::find($id);
                    
//                     if ($category) {
//                         foreach ($validatedData['venue_id'] as $venueId) {
//                             $category->venues()->attach($venueId);
//                         }
//                     } else {
//                         return response()->json(['error' => 'Category not found'], 404);
//                     }
//                 }

    
// }