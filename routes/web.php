<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;

// Route principale che utilizza Inertia per rendere il componente Home
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/{any}', function () {
    return Inertia::render('Home');
})->where('any', '.*');


Route::put('/messages/{id}', [MessageController::class, 'update']);
Route::delete('/messages/{id}', [MessageController::class, 'destroy']);




require __DIR__.'/auth.php';
