<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// message
Route::get('/', 'MessageController@index');

Route::put('/messages/{id}', [MessageController::class, 'update']);
