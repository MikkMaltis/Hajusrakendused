<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function index()
    {
        return view('weather.index');
    }
    public function fetchWeather(Request $request)
{
    $request->validate([
        'city' => 'required|string',
    ]);

    $city = $request->input('city');
    $cacheKey = "weather_{$city}";
    $cacheDuration = 10 * 60; // Cache for 10 minutes

    // Check if the weather data is already cached
    $weatherData = Cache::remember($cacheKey, $cacheDuration, function () use ($city) {
        $apiKey = Config::get('services.openweathermap.key');
        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    });

    if ($weatherData) {
        return view('weather.index', [
            'weather' => $weatherData,
            'additionalInfo' => [
                'humidity' => $weatherData['main']['humidity'],
                'wind_speed' => $weatherData['wind']['speed'],
                'wind_direction' => $weatherData['wind']['deg'],
                'feels_like' => $weatherData['main']['feels_like'],
                'icon' => $weatherData['weather'][0]['icon'],
            ],
        ]);
    }

        return back()->withErrors([
            'city' => 'City not found or API error.',
        ]);
    }
}
