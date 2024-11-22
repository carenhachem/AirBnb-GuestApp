<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function testUserid(Request $request)
    {
        // Retrieve the user ID from the authenticated user
        $userId = $request->user()->userid;
    
        // Return a response with the user ID
        return response()->json([
            'message' => 'Hello, user with ID ' . $userId
        ]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    public function create()
    {
        return view('login');
    }  
    
    // public function createProfile()
    // {
    //     return view('profile');
    // }  

    // public function showProfile()
    // {
    // // Get the authenticated user from the token
    // $user = Auth::user();

    // // Pass the user data to the view
    // return view('profile', ['user' => $user]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // Access the user ID that was added by the middleware
        $userId = $request->userid;
    
        // Retrieve the user using the extracted user ID
        $user = User::findOrFail($userId);
    
        // Pass the user data to the Blade view
        return view('profile', compact('user'));
    }
    

//     public function show(Request $request)
// {
//     // Access the user ID that was added by the middleware
//     $userId = $request->userid;

//     // Retrieve the user using the extracted user ID
//     $user = User::findOrFail($userId);

//     // Return the user data
//     return response()->json($user);
// }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
