<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FavoriteMusic;
use Illuminate\Http\Request;

class FavoriteMusicController extends Controller
{
    /**
     * Get a list of favorite music entries.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $genre = $request->input('genre');
        $artist = $request->input('artist');

        $query = FavoriteMusic::query();

        if ($genre) {
            $query->where('genre', $genre);
        }

        if ($artist) {
            $query->where('artist', $artist);
        }

        $music = $query->limit($limit)->get();

        return response()->json([
            'success' => true,
            'data' => $music,
            'total' => $music->count(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

        $music = FavoriteMusic::create($validated);

        return response()->json([
            'success' => true,
            'data' => $music,
            'message' => 'Music entry created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $music = FavoriteMusic::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $music,
        ]);
    }
}
