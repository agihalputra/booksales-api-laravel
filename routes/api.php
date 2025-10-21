<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini kamu bisa mendaftarkan route API untuk aplikasi kamu.
| Semua route ini otomatis menggunakan prefix "/api" dan middleware group "api".
|
*/

// Route default sanctum
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::apiResource('/books', BookController::class)->only('index','show');

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/authors', AuthorController::class);
    Route::apiResource('/genres', GenreController::class);

    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource('/books', BookController::class)->only('store','update', 'destroy');
    });
});


