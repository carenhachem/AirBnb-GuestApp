<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accomodation;
use App\Models\AccomodationType;
use App\Models\Amenity;

class AccomodationController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all accommodation types and amenities
        $types = AccomodationType::all();
        $amenities = Amenity::all();

        // Initialize the query for accommodations
        $query = Accomodation::query()->with(['type', 'location', 'amenities']);

        // Filter by price range (if implementing server-side filtering)
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('pricepernight', [$request->min_price, $request->max_price]);
        }

        // Filter by map bounds (if implementing server-side filtering)
        if ($request->filled('bounds')) {
            $bounds = json_decode($request->bounds, true);
            $query->whereHas('location', function($q) use ($bounds) {
                $q->whereBetween('latitude', [$bounds['south'], $bounds['north']])
                  ->whereBetween('longitude', [$bounds['west'], $bounds['east']]);
            });
        }
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'price_asc':
                    $query->orderBy('pricepernight', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('pricepernight', 'desc');
                    break;
                case 'rating_asc':
                    $query->orderBy('rating', 'asc');
                    break;
                case 'rating_desc':
                    $query->orderBy('rating', 'desc');
                    break;
            }
        }

        // Fetch the filtered accommodations
        $accomodations = $query->get();

        // Pass data to the view
        return view('accomodations.index', compact('accomodations', 'types', 'amenities'));
    }

    public function show($id)
    {
        // Fetch a specific accommodation with its related data
        $accomodation = Accomodation::with(['type', 'location', 'amenities'])->findOrFail($id);
        return view('accomodations.show', compact('accomodation'));
    }
}
