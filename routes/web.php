<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
Route::post('/weather', [WeatherController::class, 'fetchWeather'])->name('weather.fetch');
