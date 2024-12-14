<?php

namespace App\Http\Controllers;

use App\Models\reservation;
use App\Models\Accomodation;
use App\Models\wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    //reservation history
    public function index(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now();

        $filter = $request->input('filter', 'all'); //default all

        $reservations = Reservation::with('accomodation')
            ->where('userid', $user->userid)
            ->orderBy('checkin', 'asc');

        //filter based on the type
        if ($filter === 'previous') {

            $reservations = $reservations->where('checkout', '<', $today);
        } elseif ($filter === 'now') {

            $reservations = $reservations->where('checkin', '<=', $today)
                                        ->where('checkout', '>=', $today);
        } elseif ($filter === 'upcoming') {

            $reservations = $reservations->where('checkin', '>', $today);
        }

        $reservations = $reservations->get();

        return view('bookinghistory', compact('reservations'));
    }

    public function wishlist()
    {
        $user = Auth::user();

        $bookings = wishlist::with('accomodation')
        ->where('userid', $user->userid)
        ->orderBy('created', 'desc')
        ->get();

        return view('wishlisthistory',compact('bookings'));
    }

    public function destroy($id)
    {
        $user = Auth::user(); 

        $wishlist = wishlist::where('userid', $user->userid)->findOrFail($id);
        $wishlist->delete(); 
        return redirect()->back()->with('success', 'Wishlist item removed successfully.');
    }

    public function show(Accomodation $accomodation)
    {
        // Fetch existing reservations for the accommodation
        $reservedDates = Reservation::where('accomodationid', $accomodation->accomodationid)
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

    public function store(Request $request, $id)
    {
        $request->validate([
            'checkin' => 'required|date|after_or_equal:today',
            'checkout' => 'required|date|after:checkin',
        ]);

        // Check if the dates are available
        $isAvailable = Reservation::where('accomodationid', $id)
            ->where('isreserved', true)
            ->where(function ($query) use ($request) {
                $query->whereBetween('checkin', [$request->checkin, $request->checkout])
                    ->orWhereBetween('checkout', [$request->checkin, $request->checkout])
                    ->orWhereRaw('? BETWEEN checkin AND checkout', [$request->checkin])
                    ->orWhereRaw('? BETWEEN checkin AND checkout', [$request->checkout]);
            })
            ->doesntExist();

        if (!$isAvailable) {
            return back()->withErrors(['The selected dates are not available.']);
        }

        // Calculate total price
        $accomodation = Accomodation::findOrFail($id);
        $checkin = new \DateTime($request->checkin);
        $checkout = new \DateTime($request->checkout);
        $interval = $checkin->diff($checkout);
        $nights = $interval->days;
        $totalPrice = $nights * $accomodation->pricepernight;

        // Create reservation
        Reservation::create([
            'reservationid' => \Illuminate\Support\Str::uuid(),
            'userid' => Auth::user()->userid,
            'accomodationid' => $id,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'totalprice' => $totalPrice,
            'isreserved' => true,
        ]);

        return redirect()->route('booking-history')->with('success', 'Reservation created successfully.');
    }
}
