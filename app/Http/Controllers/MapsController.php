<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function index()
    {
        $markers = Marker::all();
        return view('maps.index', compact('markers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        
        Marker::create($request->all());
        return redirect()->route('maps.index')->with('success', 'Marker added!');
    }
    public function update(Request $request, Marker $marker)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $marker->update($request->all());
        return redirect()->route('maps.index')->with('success', 'Marker updated!');
    }

    public function destroy(Marker $marker)
    {
        $marker->delete();
        return redirect()->route('maps.index')->with('success', 'Marker deleted!');
    }
}
