<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        $apiKey = Config::get('services.openweathermap.key');
        $city = $request->input('city');
        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        if ($response->successful()) {
            $weatherData = $response->json();
            return view('weather.index', [
                'weather' => $weatherData,
                'additionalInfo' => [
                    'humidity' => $weatherData['main']['humidity'],
                    'wind_speed' => $weatherData['wind']['speed'],
                    'wind_direction' => $weatherData['wind']['deg'],
                    'feels_like' => $weatherData['main']['feels_like'],
                ],
            ]);
        }

        return back()->withErrors([
            'city' => 'City not found or API error. ',
        ]);
    }
}
