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

    // public function create()
    // {
    //     return view('login');
    // }  
    
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
    // public function show()
    // {
    //     // Access the user ID that was added by the middleware
    //     $userId = "09bb20af-0886-48df-9d72-de49c95c5de1";
    
    //     // Retrieve the user using the extracted user ID
    //     $user = User::findOrFail($userId);
    
    //     // Pass the user data to the Blade view
    //     return view('profile', compact('user'));
    // }

    // public function changePassword(Request $request, string $id)
    // {
    //     $request->validate([
    //         'current_password' => 'required',
    //         'new_password' => 'required|min:8|confirmed', // `confirmed` ensures it matches `new_password_confirmation`
    //     ]);

    //     $user = User::findOrFail($id);

    //     //$user = $request->user();

    //     // Check if current password matches
    //     if (!Hash::check($request->current_password, $user->password)) {
    //         return response()->json(['message' => 'Current password is incorrect.'], 400);
    //     }

    //     // Update to the new password
    //     $user->password = Hash::make($request->new_password);
    //     $user->save();

    //     return response()->json(['message' => 'Password changed successfully.'], 200);
    // }


    // Show change password form
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

    // Handle password change
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:4|confirmed'
        ]);

        $user = Auth::user();
        $data = [
            'password' => Hash::make($request->new_password),
            'updated_at' => now(),
        ];

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        DB::table('users')->where('userid', $user->userid)->update($data);

        return redirect()->route('profile')->with('success', 'User updated successfully!');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profilepic' => 'file',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
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
            $file->move(public_path('uploads/profiles'), $filename); // Save file in 'uploads/thumbnails'
            $user->profilepic = $filename; // Update thumbnail
        }

        DB::table('users')->where('userid', $user->userid)->update($data);

        return back()->with('success', 'Profile changed successfully.');
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
