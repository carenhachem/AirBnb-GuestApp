<?php

namespace App\Http\Controllers;

use App\Models\RefreshToken;
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
            // $accessToken = $user->tokens()->latest('userid')->first(); // Get the latest token
            // $accessToken->expires_at = now()->addMinutes(60); // Set expiration (e.g., 60 minutes)
            // $accessToken->save();

            $refreshToken = Str::random(60);  // You can customize this as needed
            RefreshToken::create([
                'refresh_token' => $refreshToken,
                'userid' => $user->userid, // Assuming 'user_id' is the ID field for the user
                'expires_at' => now()->addDays(30), // Set refresh token expiration
            ]);

            // return response()->json([
            //     'message' => 'Login successful!',
            //     'token' => $token,
            //     'refresh_token' => $refreshToken,  // Send refresh token in the response
            //     'profile_url' => route('profile'), // The URL for the user profile route

            // ], 200);
           //return redirect()->intended('home');
           //return redirect()->route('user.home')->with('userid', $user->userid);
        //    return response()->json([
        //     'message' => 'Login successful!',
        //     'token' => $token,
        //     'refresh_token' => $refreshToken,  // Send refresh token in the response
        //     'profile_url' => route('profile.show', $user->userid), // The URL for the user profile route
        // ], 200);

        // return response()->json([
        //     'access_token' => $token,
        //     'refresh_token' => $refreshToken,
        // ]);
        return redirect()->route('profile.show', $user->userid)->with('success', 'User updated successfully!');

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
        $expiresAt = now()->addMinutes(60); // Example for token expiration

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
                $token = $new_user->createToken('API Token')->plainTextToken;
                return redirect()->intended('home');
            }
            else{
                Auth::login($user);
                $token = $user->createToken('API Token')->plainTextToken;
                return redirect()->intended('home');
            }

        } catch (\Throwable $th) {
            dd('something went wrong'.$th->getMessage());
        }        
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

    public function refresh(Request $request)
    {
        // Validate incoming refresh token
        $request->validate([
            'refresh_token' => 'required|string',
        ]);

        // Check if the refresh token is valid and not expired
        $refreshToken = RefreshToken::where('refresh_token', $request->refresh_token)
                                    ->where('expires_at', '>', now())
                                    ->first();

        if (!$refreshToken) {
            return response()->json(['message' => 'Invalid or expired refresh token'], 401);
        }

        // Generate new API token
        $user = $refreshToken->user;
        $newToken = $user->createToken('API Token')->plainTextToken;

        // Optionally, you can also generate a new refresh token here and store it
        // $newRefreshToken = Str::random(60);
        // RefreshToken::create([
        //     'refresh_token' => $newRefreshToken,
        //     'user_id' => $user->id,
        //     'expires_at' => now()->addDays(30),
        // ]);

        // Return response with new token
        return response()->json(['token' => $newToken]);
    }

    // In AuthController.php

    public function logout(Request $request)
    {
        // Revoke the user's current access token
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        // Optionally, you can delete the refresh token from the database if you want
        $refreshToken = RefreshToken::where('userid', $request->user()->userid)->first();
        if ($refreshToken) {
            $refreshToken->delete();
        }

        // Return a response indicating the user has logged out
        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
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