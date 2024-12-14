<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accomodation;
use App\Models\AccomodationType;
use App\Models\Amenity;
use App\Models\Reservation;
use App\Models\wishlist;
use Illuminate\Support\Facades\Auth;

class AccomodationController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all accommodation types and amenities
        $types = AccomodationType::all();
        $amenities = Amenity::all();

        // Initialize the query for accommodations
        $query = Accomodation::query()->with(['type', 'location', 'amenities']);

        // Keyword search (description, city, type)
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function($q) use ($keyword) {
                $q->where('description', 'ILIKE', "%{$keyword}%")
                  ->orWhereHas('location', function($locQ) use ($keyword) {
                      $locQ->where('city', 'ILIKE', "%{$keyword}%")
                           ->orWhere('address', 'ILIKE', "%{$keyword}%");
                  })
                  ->orWhereHas('type', function($typeQ) use ($keyword) {
                      $typeQ->where('accomodationdesc', 'ILIKE', "%{$keyword}%");
                  });
            });
        }

        // Filter by city
        if ($request->filled('city')) {
            $city = $request->input('city');
            $query->whereHas('location', function($q) use ($city) {
                $q->where('city', 'ILIKE', "%{$city}%");
            });
        }

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

        // Filter by type of accommodation
        if ($request->filled('type')) {
            $query->whereHas('type', function ($q) use ($request) {
                $type = $request->input('type');
                $q->where('accomodationdesc', 'ILIKE', "%{$type}%");
            });
        }

        // Filter by guest capacity
        if ($request->filled('guestCapacity')) {
            $query->where('guestcapacity', '>=', (int)$request->input('guestCapacity'));
        }

        // Filter by minimum rating
        if ($request->filled('rating')) {
            $query->where('rating', '>=', (int)$request->input('rating'));
        }

        // Filter by amenities
        if ($request->filled('amenities')) {
            $amenitiesFilter = $request->input('amenities');
            if (!is_array($amenitiesFilter)) {
                $amenitiesFilter = [$amenitiesFilter];
            }

            $query->whereHas('amenities', function ($q) use ($amenitiesFilter) {
                $q->whereIn('amenitydesc', $amenitiesFilter);
            });
        }

        // Filter by availability (check-in and checkout dates)
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

        // Fetch accommodations with pagination
        $accomodations = $query->paginate(10); // Adjust per-page as needed
        $accomodations->appends($request->all());

        // Fetch wishlist items for logged in user
        $wishlistItems = Auth::check()
            ? wishlist::where('userid', Auth::id())->pluck('accomodationid')->toArray()
            : [];

        if ($request->ajax()) {
            // Return only the partial view if AJAX
            return view('accomodations.partials._list', compact('accomodations', 'wishlistItems'))->render();
        }

        return view('accomodations.index', compact('accomodations', 'types', 'amenities', 'wishlistItems'));
    }

    public function show($id)
    {
        // Fetch the accommodation with related data
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

        // Check if in wishlist
        $isInWishlist = Auth::check()
            ? wishlist::where('userid', Auth::id())
                ->where('accomodationid', $id)
                ->exists()
            : false;

        return view('accomodations.show', compact('accomodation', 'unavailableDates', 'isInWishlist'));
    }

    public function toggleWishlist(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['error' => 'Not authenticated'], 401);
    }

    $request->validate([
        'accomodationid' => 'required|exists:accomodations,accomodationid',
    ]);

    $userId = Auth::id();
    $accomodationId = $request->accomodationid;

    $existing = \App\Models\wishlist::where('userid', $userId)
                 ->where('accomodationid', $accomodationId)
                 ->first();

    if ($existing) {
        // Remove from wishlist
        $existing->delete();
        return response()->json(['message' => 'Removed from wishlist', 'status' => 'removed']);
    } else {
        // Add to wishlist
        $wishlist = new \App\Models\wishlist();
        $wishlist->wishlistid = (string) \Illuminate\Support\Str::uuid();
        $wishlist->userid = $userId;
        $wishlist->accomodationid = $accomodationId;
        $wishlist->save();

        return response()->json(['message' => 'Added to wishlist', 'status' => 'added']);
    }
}


}
