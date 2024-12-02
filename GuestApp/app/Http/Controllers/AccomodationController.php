<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accomodation;
use App\Models\AccomodationType;
use App\Models\Amenity;
use App\Models\Reservation;

class AccomodationController extends Controller
{
    public function index(Request $request)
{
    // Fetch all accommodation types and amenities
    $types = AccomodationType::all();
    $amenities = Amenity::all();

    // Initialize the query for accommodations
    $query = Accomodation::query()->with(['type', 'location', 'amenities']);

    // Filter by price range
    if ($request->filled('min_price') && $request->filled('max_price')) {
        $query->whereBetween('pricepernight', [$request->min_price, $request->max_price]);
    }

    // Filter by map bounds
    if ($request->filled('bounds')) {
        $bounds = json_decode($request->bounds, true);
        $query->whereHas('location', function ($q) use ($bounds) {
            $q->whereBetween('latitude', [$bounds['south'], $bounds['north']])
              ->whereBetween('longitude', [$bounds['west'], $bounds['east']]);
        });
    }

    // Filter by availability (checkin and checkout dates)
    if ($request->filled('checkin') && $request->filled('checkout')) {
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');

        $query->whereDoesntHave('reservations', function ($query) use ($checkin, $checkout) {
            $query->where('isreserved', true)
                ->where(function ($query) use ($checkin, $checkout) {
                    $query->whereBetween('checkin', [$checkin, $checkout])
                          ->orWhereBetween('checkout', [$checkin, $checkout])
                          ->orWhereRaw('? BETWEEN checkin AND checkout', [$checkin])
                          ->orWhereRaw('? BETWEEN checkin AND checkout', [$checkout]);
                });
        });
    }

    // Sorting logic
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

    // Fetch accommodations
    $accomodations = $query->get();

    return view('accomodations.index', compact('accomodations', 'types', 'amenities'));
}


    public function show($id)
{
    // Fetch the accommodation with its related data
    $accomodation = Accomodation::with(['type', 'location', 'amenities'])->findOrFail($id);

    // Fetch existing reservations for the accommodation
    $reservedDates = Reservation::where('accomodationid', $id)
        ->where('isreserved', true)
        ->get(['checkin', 'checkout']);

    // Format dates for JavaScript
    $unavailableDates = [];
    foreach ($reservedDates as $reservation) {
        $period = new \DatePeriod(
            new \DateTime($reservation->checkin),
            new \DateInterval('P1D'),
            (new \DateTime($reservation->checkout))->modify('+1 day')
        );

        foreach ($period as $date) {
            $unavailableDates[] = $date->format('Y-m-d');
        }
    }

    return view('accomodations.show', compact('accomodation', 'unavailableDates'));
}

}
