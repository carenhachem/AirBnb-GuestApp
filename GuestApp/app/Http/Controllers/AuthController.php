<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\usertoken;
use Illuminate\Support\Str; 


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create()
    {
        return view('signup');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            // $validated = $request->validate([
            //     'firstname' => 'required|string|max:255',
            //     'lastname' => 'required|string|max:255',
            //     'email' => 'required|email|unique:users,email',
            //     'username' => 'required|string|max:255|unique:users,username',
            //     'password' => 'required|string|min:8',
            // ]);
            
            // Create a new user
            $user = User::create([
                'userid' => Str::uuid(),  // Manually set the UUID
                'firstname' => $request['firstname'],
                'lastname' => $request['lastname'],
                'email' => $request['email'],
                'username' => $request['username'],
                'password' => bcrypt($request['password']),  // Encrypt password
            ]);
            //dd($user);  // Add this line to inspect the $user object

            // Explicitly retrieve the 'userid' after creating the user
            //$user->refresh(); // Ensures that the 'userid' is populated if it was not auto-loaded

            //dd($user);

    
            // Check if the 'userid' is set
            // if (!$user->userid) {
            //     throw new \Exception('User ID was not generated.');
            // }
    
            // Generate API token for the user
            $token = $user->createToken('API Token')->plainTextToken;
    
            // Create a usertoken record with the correct user ID
            // usertoken::create([
            //     'token' => $token,
            //     'refreshtoken' => null,
            //     'userid' => $user->userid, // Use the correct user ID
            // ]);
    
            // Return a success response with the user data and token
            return response()->json([
                'message' => 'Registration successful!',
                'token' => $token,
            ], 201); // 201: Created status
        } catch (\Exception $e) {
            // Handle errors (if any)
            return response()->json([
                'error' => 'An error occurred while registering.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

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