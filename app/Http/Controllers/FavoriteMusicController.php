<?php

namespace App\Http\Controllers;

use App\Models\FavoriteMusic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FavoriteMusicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $music = FavoriteMusic::all();
        return view('music.index', compact('music'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('music.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|url',
            'description' => 'required|string',
            'artist' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
        ]);

        FavoriteMusic::create($validated);

        return redirect()->route('music.index')
            ->with('success', 'Music entry added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FavoriteMusic $music)
    {
        return view('music.show', compact('music'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FavoriteMusic $music)
    {
        return view('music.edit', compact('music'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FavoriteMusic $music)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|url',
            'description' => 'required|string',
            'artist' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
        ]);

        $music->update($validated);

        return redirect()->route('music.index')
            ->with('success', 'Music entry updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoriteMusic $music)
    {
        $music->delete();

        return redirect()->route('music.index')
            ->with('success', 'Music entry deleted successfully!');
    }

    /**
     * Proxy requests to external API with caching.
     */
    public function proxyExternalApi()
    {
        // Cache key and duration (cache for 30 minutes)
        $cacheKey = 'external_subjects_api';
        $cacheDuration = 30 * 60;

        // Try to get data from cache first
        return Cache::remember($cacheKey, $cacheDuration, function () {
            try {
                $response = Http::get('https://hajusrakendus.tak22jasin.itmajakas.ee/api/subjects');

                if ($response->successful()) {
                    return $response->json();
                }

                return ['error' => 'Failed to fetch data'];
            } catch (\Exception $e) {
                return ['error' => $e->getMessage()];
            }
        });
    }
}
