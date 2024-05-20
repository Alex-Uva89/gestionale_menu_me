<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HomeController;



Route::get('/', function () {
    return Inertia::render('Home', [
        // 'canLogin' => Route::has('login'),
        // 'canRegister' => Route::has('register'),
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::put('/messages/{id}', [MessageController::class, 'update']);




require __DIR__.'/auth.php';
