<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\MapsController;

Route::resource('weather', WeatherController::class);
Route::post('weather/fetch', [WeatherController::class, 'fetchWeather'])->name('weather.fetchWeather');

Route::resource('maps', MapsController::class);
