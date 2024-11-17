<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Giphy\SearchGifsController;
use App\Http\Controllers\Giphy\ShowGifController;
use App\Http\Controllers\Giphy\SaveFavoriteGifController;
use App\Http\Controllers\Giphy\ListFavoriteGifsController;
use App\Http\Controllers\Giphy\DeleteFavoriteGifController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API authentication and user management routes.
| All routes use the 'api' prefix automatically.
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // User routes
    Route::prefix('user')->group(function () {
        Route::get('/', [AuthController::class, 'user']);
        Route::get('/favorites', ListFavoriteGifsController::class);
        Route::delete('/favorites/{id}', DeleteFavoriteGifController::class);
    });

    // Gifs routes
    Route::prefix('gifs')->group(function () {
        Route::get('/search', SearchGifsController::class);
        Route::get('/{id}', ShowGifController::class);
        Route::post('/favorite', SaveFavoriteGifController::class);
    });
});
