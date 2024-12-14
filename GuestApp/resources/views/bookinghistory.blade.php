<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bookinghistory.css') }}">
</head>
<body>
    <div class="container">
        <div class="booking-header">
            <div class="icon">🗓️</div>
            <h1>Booking History</h1>
        </div>

        <!-- Filter buttons -->
        <div class="filter-dropdown">
            <label for="filter">Filter by:</label>
            <select id="filter" onchange="window.location.href='?filter=' + this.value">
                <option value="all" {{ request()->input('filter') == 'all' ? 'selected' : '' }}>All Reservations</option>
                <option value="previous" {{ request()->input('filter') == 'previous' ? 'selected' : '' }}>Previous Reservations</option>
                <option value="now" {{ request()->input('filter') == 'now' ? 'selected' : '' }}>Current Reservations</option>
                <option value="upcoming" {{ request()->input('filter') == 'upcoming' ? 'selected' : '' }}>Upcoming Reservations</option>
            </select>
        </div>

        <!-- Reservations will be displayed here -->
        <div id="reservation-list">
            @foreach ($reservations as $booking)
                <div class="reservation-card">
                    <!-- Accommodation Image -->
                    <div class="accommodation-img-container">
                        @php
                            $imageData = json_decode($booking->accomodation->image, true);
                            $imageUrl = $imageData['url'] ?? 'https://via.placeholder.com/60';
                        @endphp
                        <img src="{{ asset('images/' . $imageUrl) }}" alt="Accommodation Image" class="product-image">
                    </div>

                    <div class="reservation-info">
                        <h2>{{ $booking->accomodation->description ?: 'Accommodation' }}</h2>
                        <div class="accordion-content">
                            <p><strong>Check-in:</strong> {{ $booking->checkin }}</p>
                            <p><strong>Check-out:</strong> {{ $booking->checkout }}</p>
                            <p><strong>Location:</strong> {{ $booking->accomodation->location->city ?: 'Not Specified' }}</p>
                            <p><strong>Price per Night:</strong> ${{ number_format($booking->totalprice, 2) }}</p>
                        </div>
                    
                        <div class="reservation-actions">
                            <a href="{{ route('accomodations.show', ['id' => $booking->accomodationid]) }}" class="details-btn">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
