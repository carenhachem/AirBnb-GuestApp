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
                <button class="social-button github">GITHUB</button>
                <button class="social-button google">GOOGLE</button>
            </div>
            <p class="or-signup">Or sign up with credentials</p>
            <form id="signup-form" method="post" action="{{ route('user.store') }}"> 
                @csrf
                <div class="form-group">
                    <input type="text" name="firstname" id="first-name" placeholder="First Name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="lastname" id="last-name" placeholder="Last Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="username" id="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>
                <div id="password-strength">Password strength: <span id="strength-indicator">weak</span></div>
                <button type="submit" class="submit-button">CREATE ACCOUNT</button>
            </form>
        </div>
    </div>
    <script src="js/signup.js"></script>
</body>
</html>
