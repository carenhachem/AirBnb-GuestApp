<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function showProfile()
    {
        if (Auth::check()) {
            Log::info('User is authenticated.');
        } else {
            Log::info('User is not authenticated.');
        }
        
        Log::info('hi');

        $user = Auth::user();

        Log::info('Authenticated user accessed the profile page', [
            'userid' => $user->userid,
            'email' => $user->email,
        ]);

        return view('profile', ['user' => $user]); // Pass user data to the blade view
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:4|confirmed'
        ], [
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.string' => 'New password must be a string.',
            'new_password.min' => 'New password must be at least 4 characters long.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);

        $user = Auth::user();
        $data = [
            'password' => Hash::make($request->new_password),
            'updated_at' => now(),
        ];

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
        }

        DB::table('users')->where('userid', $user->userid)->update($data);

        return redirect()->route('profile')->with('success', 'User updated successfully!');
    }


    public function updateProfile(Request $request)
    {
        $request->validate([
            'profilepic' => 'file|image|mimes:jpeg,png,jpg||max:2048',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
        ], [
            'profilepic.file' => 'The profile picture must be a valid file.',
            'profilepic.mimes' => 'The profile picture must be a JPG, JPEG, PNG, or GIF.',
            'profilepic.max' => 'The profile picture size must not exceed 800 KB.',
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a valid string.',
            'first_name.max' => 'First name must not exceed 50 characters.',
            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a valid string.',
            'last_name.max' => 'Last name must not exceed 50 characters.',
        ]);

        $user = Auth::user();
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'updated_at' => now(),
        ];

        if ($request->hasFile('profilepic')) {
            $file = $request->file('profilepic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename); 
            $user->profilepic = $filename; 
        }

        DB::table('users')->where('userid', $user->userid)->update($data);

        return back()->with('success', 'Profile changed successfully.');
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
