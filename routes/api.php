<?php

use App\Http\Controllers\API\FavoriteMusicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('music')->group(function () {
    Route::get('/', [FavoriteMusicController::class, 'index']);
    Route::post('/', [FavoriteMusicController::class, 'store']);
    Route::get('/{id}', [FavoriteMusicController::class, 'show']);
});
