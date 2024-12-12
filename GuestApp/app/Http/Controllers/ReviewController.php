<?php

namespace App\Http\Controllers;

use App\Models\Accomodation;
use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index($id)
    {
        $accomodation = Accomodation::with('reviews.user')->findOrFail($id);
        return view('accomodations.show', compact('accomodation'));
    }

    public function store(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'rating' => 'required',
            'review' => 'required|string|max:255',
        ]);

        $review = review::create([
            'accomodationid' => $id,
            'rating' => $request['rating'],
            'review' => $request['review'],
            'userid' => $user->userid,
        ]);

        return redirect()->back()->with('success', 'Review added successfully.');
    }
}
