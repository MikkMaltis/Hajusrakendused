<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::resource('weather', WeatherController::class);
Route::post('weather/fetch', [WeatherController::class, 'fetchWeather'])->name('weather.fetchWeather');

Route::get('/maps', [App\Http\Controllers\MarkerController::class, 'index'])->name('maps.index');
Route::post('/maps', [App\Http\Controllers\MarkerController::class, 'store'])->name('maps.store');
Route::put('/maps/{marker}', [App\Http\Controllers\MarkerController::class, 'update'])->name('maps.update');
Route::delete('/maps/{marker}', [App\Http\Controllers\MarkerController::class, 'destroy'])->name('maps.destroy');
