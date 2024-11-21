<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link href="{{ asset('css/signup.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="signup-form">
            <h2>Sign up with</h2>
            <div class="social-signup">
                <a href="{{ route('google-auth') }}" class="social-button">Google</a>
                <a href="{{ url('login/facebook') }}" class="social-button">Facebook</a>
            </div>
            <p class="or-signup">Or sign up with credentials</p>
            
            <form id="signup-form" method="post" action="{{ route('user.store') }}"> 
                @csrf

                <div class="form-group">
                    <input type="text" name="first_name" id="first-name" placeholder="First Name" required value="{{ old('first_name') }}">
                    {{-- @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror --}}
                </div>

                <div class="form-group">
                    <input type="text" name="last_name" id="last-name" placeholder="Last Name" required value="{{ old('last_name') }}">
                    {{-- @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror --}}
                </div>

                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="Email" required value="{{ old('email') }}">
                    {{-- @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror --}}
                </div>

                <div class="form-group">
                    <input type="text" name="username" id="username" placeholder="Username" required value="{{ old('username') }}">
                    {{-- @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror --}}
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    {{-- @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror --}}
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password">
                </div>

                <div id="password-strength">Password strength: <span id="strength-indicator">weak</span></div>

                <button type="submit" class="submit-button">CREATE ACCOUNT</button>
            </form>
        </div>
    </div>
    <script src="js/signup.js"></script>
</body>
</html>
