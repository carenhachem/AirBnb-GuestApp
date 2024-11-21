<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\usertoken;
use Illuminate\Support\Str; 
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

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

    public function createLogin()
    {
        return view('login');
    }    

    // Login using email or username and password
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email_or_username' => 'required|string', // email or username field
            'password' => 'required|string',
        ]);

        // Attempt to login by email or username
        $user = User::where('email', $request->email_or_username)
            ->orWhere('username', $request->email_or_username)
            ->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            // Authentication passed, create a token for the user
            $token = $user->createToken('API Token')->plainTextToken;

            // return response()->json([
            //     'message' => 'Login successful!',
            //     'token' => $token,
            // ], 200);
            return redirect()->intended('home');
        }

        // Authentication failed
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:4|confirmed'
        ]);

        // Prepare the user data
        $userData = $request->except('password_confirmation');
        $userData['password'] = bcrypt($request->password);

        // Create the user
        $user = User::create([
            'userid' => Str::uuid(),
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => $userData['password'],
        ]);

        // Generate API token
        $token = $user->createToken('API Token')->plainTextToken;

        // Return response with token
        return response()->json([
            'message' => 'Registration successful!',
            'token' => $token,
        ], 201);
    }

    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google Callback
    public function callbackGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // If user does not exist, create new user
                $new_user = User::create([
                    'userid' => Str::uuid(),
                    'first_name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                ]);

                Auth::login($new_user);

                return redirect()->intended('home');
            }
            else{
                Auth::login($user);
                return redirect()->intended('home');
            }

        } catch (\Throwable $th) {
            dd('something went wrong'.$th->getMessage());
        }
        
       // $token = $user->createToken('API Token')->plainTextToken;
    }

    // Redirect to Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Handle Facebook Callback
    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        // Check if user exists
        $user = User::where('email', $facebookUser->getEmail())->first();

        if (!$user) {
            // Register new user if not exists
            $user = User::create([
                'first_name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'password' => bcrypt(Str::random(16)), // Random password
            ]);
        }

        // Log the user in
        Auth::login($user);

        // Generate API token
        $token = $user->createToken('API Token')->plainTextToken;

        // Return response with token
        return response()->json([
            'message' => 'Logged in successfully',
            'token' => $token,
        ]);
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