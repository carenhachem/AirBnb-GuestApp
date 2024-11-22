<?php

namespace App\Http\Controllers;

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
