<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccomodationType;
use App\Http\Controllers\AccomodationTypeController;

class AccomodationTypeController extends Controller
{
    /**
     * Display a listing of accommodation types.
     */
    public function index()
    {
        // Fetch all types
        $types = AccomodationType::all();

        // Return the view with types
        return view('types.index', compact('types'));
    }

    /**
     * Show a specific accommodation type with related accommodations.
     */
    public function show($id)
    {
        // Find the type by ID and eager load accommodations
        $type = AccomodationType::with('accomodations')->findOrFail($id);

        // Return the view with the specific type and its accommodations
        return view('types.show', compact('type'));
    }
}
