<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Dish;

class PairingsController extends Controller
{
    public function index(): JsonResponse
    {
        $pairings_enoteca = Dish::with('drinks')->where('venue_id', 3)->get();


        return response()->json([
            'pairingsEnoteca' => $pairings_enoteca,
        ]);
    }
}