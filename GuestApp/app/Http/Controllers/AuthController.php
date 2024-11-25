<?php

namespace App\Http\Controllers;

use App\Models\RefreshToken;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\usertoken;
use Illuminate\Support\Str; 
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
 

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'username_or_email' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = [
            'password' => $request->password,
        ];
    
        // Determine if the input is an email or username
        if (filter_var($request->username_or_email, FILTER_VALIDATE_EMAIL)) {
            // It's an email
            $credentials['email'] = $request->username_or_email;
        } else {
            // It's a username
            $credentials['username'] = $request->username_or_email;
        }
    
        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // Retrieve authenticated user's ID
            $user = Auth::user();

            Log::info('User successfully logged in', [
                'userid' => $user->userid,
                'firstname' => $user->first_name,
                'email' => $user->email,
            ]);
            
            return redirect()->route('profile')->with('success', "Logged in! User ID: {$user->userid}");
        }

        return back()->withErrors(['error' => 'Wrong credentials.'])->withInput();
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

        Auth::login($user);

        return redirect()->route('profile')->with('success', "Signed up! User ID: {$user->userid}");
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