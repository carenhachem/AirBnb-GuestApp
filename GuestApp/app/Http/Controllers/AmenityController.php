<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    // Display a list of amenities
    public function index()
    {
        $amenities = Amenity::all();
        return view('amenities.index', compact('amenities'));
    }

    // Show a specific amenity
    public function show($id)
    {
        $amenity = Amenity::findOrFail($id);
        return view('amenities.show', compact('amenity'));
    }

    // Store a new amenity
    public function store(Request $request)
    {
        $request->validate([
            'amenitydesc' => 'required|string|max:255',
            'isactive' => 'boolean',
        ]);

        Amenity::create($request->all());
        return redirect()->route('amenities.index')->with('success', 'Amenity created successfully.');
    }

    // Update an existing amenity
    public function update(Request $request, $id)
    {
        $request->validate([
            'amenitydesc' => 'required|string|max:255',
            'isactive' => 'boolean',
        ]);

        $amenity = Amenity::findOrFail($id);
        $amenity->update($request->all());
        return redirect()->route('amenities.index')->with('success', 'Amenity updated successfully.');
    }

    // Delete an amenity
    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();
        return redirect()->route('amenities.index')->with('success', 'Amenity deleted successfully.');
    }
}
