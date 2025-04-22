<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    public function index()
    {
        $markers = Marker::all();
        return view('maps.index', compact('markers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Marker::create($validated);

        return redirect()->route('maps.index')->with('success', 'Marker added successfully!');
    }

    public function update(Request $request, Marker $marker)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $marker->update($validated);

        return redirect()->route('maps.index')->with('success', 'Marker updated successfully!');
    }

    public function destroy(Marker $marker)
    {
        $marker->delete();

        return redirect()->route('maps.index')->with('success', 'Marker deleted successfully!');
    }
}
