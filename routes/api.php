<?php

use App\Http\Controllers\AllergenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// GET
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/dishes/{id}', [DishController::class, 'show']);



// PUT
Route::put('/', [HomeController::class, 'update'])->name('update');
Route::put('/messages/{id}', [MessageController::class, 'update']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::put('/allergens/{id}', [AllergenController::class, 'update']);
Route::put('/recipes/{id}', [RecipeController::class, 'update']);

// POST
Route::post('/', [HomeController::class, 'store'])->name('store');
Route::post('/categories', [CategoryController::class, 'store']);
Route::post('/categories/{id}/venues', [HomeController::class, 'attachVenues']);
Route::post('/dishes/{id}', [DishController::class, 'store']);
Route::post('/allergens', [AllergenController::class, 'store']);
Route::post('/recipes', [RecipeController::class, 'store']);

// DELETE
Route::delete('/', [HomeController::class, 'destroy'])->name('destroy');
Route::delete('/messages/{id}', [MessageController::class, 'destroy']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
Route::delete('/dishes/{categoryId}', [DishController::class, 'destroyByCategory']);
Route::delete('/allergens/{id}', [AllergenController::class, 'destroy']);
Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);


require __DIR__.'/auth.php';
