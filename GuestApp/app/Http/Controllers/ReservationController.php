<?php

namespace App\Http\Controllers;

use App\Models\reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $bookings = reservation::with('accomodation')
        ->where('userid', $user->userid)
        ->orderBy('created', 'desc')
        ->get();

        return view('bookinghistory',compact('bookings'));
    }

    public function wishlist()
    {
        $user = Auth::user();

        $bookings = reservation::with('accomodation')
        ->where('userid', $user->userid)
        ->orderBy('created', 'desc')
        ->get();

        return view('wishlisthistory',compact('bookings'));
    }
}
