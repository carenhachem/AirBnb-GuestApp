<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link href="{{ asset('css/signup.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="signup-form">
            <h2>Sign up with</h2>
            <div class="social-signup">
                <a href="{{ route('google-auth') }}" class="social-button">
                    <i class="fab fa-google"></i>
                </a>
                <!-- Facebook Login Button with Font Awesome Icon -->
                <a href="{{ url('login/facebook') }}" class="social-button">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </div>
            <div class="line"></div>
            {{-- <p class="or-signup">Or sign up with credentials</p> --}}
            
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

                <div id="password-strength" style="display: none;">
                    Password strength: <span id="strength-indicator">weak</span>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password">
                </div>

                <button type="submit" class="submit-button">Sign up</button>
            </form>
            <p class="already-have-account">
                Already have an account? <a href="#" class="link">Login here</a>
            </p>
        </div>
    </div>
    {{-- <script src="js/signup.js"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const strengthIndicator = document.getElementById('strength-indicator');
            const passwordStrengthDiv = document.getElementById('password-strength');

            passwordInput.addEventListener('input', function () {
                const value = passwordInput.value;
                let strength = "weak";

                // Show the password strength div when the user starts typing
                if (value.length > 0) {
                    passwordStrengthDiv.style.display = "block";
                } else {
                    passwordStrengthDiv.style.display = "none"; // Hide when the input is empty
                }

                // Check for strength (example conditions: length, uppercase, digits, special characters)
                if (value.length >= 8 && /[A-Z]/.test(value) && /[0-9]/.test(value) && /[@$!%*?&#]/.test(value)) {
                    strength = "strong";
                } else if (value.length >= 6) {
                    strength = "medium";
                }

                // Update the strength indicator text and color
                strengthIndicator.textContent = strength;
                strengthIndicator.style.color = (strength === "strong") ? "green" : (strength === "medium") ? "orange" : "red";
            });
        });
    </script>
</body>
</html>
