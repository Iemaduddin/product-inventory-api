<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukLokasiController;
use App\Http\Controllers\KategoriProdukController;



// login
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    // Info user yang sedang login
    Route::get('/me', [AuthController::class, 'me']);
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // ✅ Hanya admin bisa kelola roles & users
    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('users', UserController::class);
    });

    // ✅ Hanya admin bisa kelola kategori produk
    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::apiResource('kategori-produk', KategoriProdukController::class);
    });

    // ✅ hanya admin dan staff boleh kelola produk, lokasi, mutasi
    Route::middleware([CheckRole::class . ':admin,staff'])->group(function () {
        // CRUD Produk
        Route::apiResource('produk', ProdukController::class);
        // CRUD Lokasi
        Route::apiResource('lokasi', LokasiController::class);
        // Get & Set Data Produk-Lokasi
        Route::get('/produk-lokasi', [ProdukLokasiController::class, 'index']);
        Route::post('/produk-lokasi', [ProdukLokasiController::class, 'store']);
        // CRUD Mutasi
        Route::apiResource('mutasi', MutasiController::class);
    });

    // ✅ Semua role bisa lihat histori mutasi
    Route::get('/produk/{id}/mutasi', [ProdukController::class, 'mutasi']);
    Route::get('/user/{id}/mutasi', [MutasiController::class, 'userMutasi']);
});
