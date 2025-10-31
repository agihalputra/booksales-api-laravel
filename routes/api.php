<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==============================
// 🔐 Default Sanctum User Info
// ==============================
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// ==============================
// 🔑 Auth routes
// ==============================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ==============================
// 🔑 User authenticated customer
// ==============================
Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/transactions', [TransactionController::class, 'store']); // buat transaksi
    Route::get('/transactions/{id}', [TransactionController::class, 'show']); // lihat detail transaksi
});

// ==============================
// 🆓 ROUTE PUBLIK
// ==============================
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/genres', [GenreController::class, 'index']);

// ==============================
// 📦 ROUTE UNTUK CUSTOMER LOGIN
// ==============================
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/transactions', TransactionController::class)->only(['store', 'show']);
    Route::apiResource('/authors', AuthorController::class)->only(['show']);
    Route::apiResource('/genres', GenreController::class)->only(['show']);
});

// ==============================
// 🧑‍💼 ROUTE UNTUK ADMIN (TANPA TOKEN)
// ==============================
Route::group([], function () {
    Route::apiResource('/books', BookController::class)->only([
        'store', 'update', 'destroy'
    ]);

    Route::apiResource('/transactions', TransactionController::class)->only(['index', 'destroy']);
});
