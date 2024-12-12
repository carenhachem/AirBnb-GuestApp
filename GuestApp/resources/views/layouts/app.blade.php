<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Airbnb Guest App')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Your custom CSS -->
    <!-- Mapbox CSS -->


</head>
<body>
    <!-- Include Header -->
    @include('includes.header')

    <main class="container py-4">
        <!-- Yield Content -->
        @yield('content')
    </main>

    <!-- Include Footer -->
    @include('includes.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script> <!-- Your custom JS -->
    @stack('scripts') <!-- For adding page-specific scripts -->
</body>
</html>
