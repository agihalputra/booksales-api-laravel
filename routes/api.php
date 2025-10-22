<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Default route Sanctum
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// ==============================
// 📦 ROUTE UNTUK CUSTOMER LOGIN
// ==============================
Route::middleware(['auth:api'])->group(function () {
    // Customer boleh: Create, Update, dan Show
    Route::apiResource('/books', BookController::class)->only(['store', 'update', 'show']);
    Route::apiResource('/transactions', TransactionController::class)->only(['store', 'show']);

    // Customer juga bisa lihat data relasi (author & genre)
    Route::apiResource('/authors', AuthorController::class)->only(['index', 'show']);
    Route::apiResource('/genres', GenreController::class)->only(['index', 'show']);
});

// ==============================
// 🧑‍💼 ROUTE UNTUK ADMIN
// ==============================
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    // Admin boleh Read All dan Destroy
    Route::apiResource('/books', BookController::class)->only(['index', 'destroy']);
    Route::apiResource('/transactions', TransactionController::class)->only(['index', 'destroy']);
});
