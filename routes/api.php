<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// GET
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');


// PUT
Route::put('/', [HomeController::class, 'update'])->name('update');
Route::put('/messages/{id}', [MessageController::class, 'update']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);

// POST
Route::post('/', [HomeController::class, 'store'])->name('store');
Route::post('/categories', [CategoryController::class, 'store']);




require __DIR__.'/auth.php';
