<?php

namespace App\Http\Controllers;

use App\Models\reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index($userid)
    {
        // Fetch reservations from the database
        // $reservations = reservation::where('userid', auth()->id()) // Optional: Filter by authenticated user
        $bookings = reservation::with('accomodation') // Eager load accommodation
            ->where('userid', $userid) // Filter by the logged-in user's ID
            ->orderBy('created', 'desc') // Order by creation date or other criteria
            ->get();

        // Return the view with the bookings data
        return view('bookinghistory', compact('bookings'));
    }
}
