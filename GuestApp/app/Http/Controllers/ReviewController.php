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

        if (!$user) {
            session([
                'review_data' => $request->only('rating', 'review')
            ]);
    
            return redirect()->route('login');  
        }

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

        $averageRating = review::where('accomodationid', $id)
        ->avg('rating');

        $accomodation = accomodation::findOrFail($id);
        $accomodation->rating = round($averageRating, 1); 
        $accomodation->save();

        session()->forget('review_data');

        return redirect()->back()->with('success', 'Review added successfully.');
    }
}
