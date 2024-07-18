<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;

// MAIN route controller
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route image storage
Route::get('/storage/immagini/{filename}', function ($filename) {
    $path = storage_path('app/public/immagini/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});


// Route with Inertia.js
Route::get('/{any}', function () {
    return Inertia::render('Home');
})->where('any', '.*');

Route::put('/messages/{id}', [MessageController::class, 'update']);
Route::delete('/messages/{id}', [MessageController::class, 'destroy']);

require __DIR__.'/auth.php';

