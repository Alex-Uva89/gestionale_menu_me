<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Dish;

class PairingsController extends Controller
{
    public function index(): JsonResponse
    {
        $pairings_All = Dish::with('drinks')->get();


        return response()->json([
            'pairings' => $pairings_All
        ]);
    }
}