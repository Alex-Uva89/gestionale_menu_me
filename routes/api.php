<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\HomeController;

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

// POST
Route::post('/', [HomeController::class, 'store'])->name('store');
Route::post('/categories', [CategoryController::class, 'store']);
Route::post('/categories/{id}/venues', [HomeController::class, 'attachVenues']);
Route::post('/dishes/{id}', [DishController::class, 'store']);

// DELETE
Route::delete('/', [HomeController::class, 'destroy'])->name('destroy');
Route::delete('/messages/{id}', [MessageController::class, 'destroy']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
Route::delete('/dishes/{categoryId}', [DishController::class, 'destroyByCategory']);


require __DIR__.'/auth.php';
