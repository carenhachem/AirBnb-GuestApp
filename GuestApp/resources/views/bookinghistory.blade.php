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
        <?php foreach ($bookings as $booking): ?>
            <div class="reservation-card">
                <!-- Accommodation Image -->
                <div class="accommodation-img-container">
                    @php
                        // Decode the image JSON field to get the URL of the image
                        $imageData = json_decode($booking->accomodation->image, true);
                        // Get the image URL (use placeholder if not set)
                        $imageUrl = $imageData['url'] ?? 'https://via.placeholder.com/60';
                    @endphp
                    <img src="{{ asset('images/' . $imageUrl) }}" alt="Accommodation Image" class="product-image">
                </div>

                <div class="reservation-info">
                    <h2><?php echo $booking->accomodation->description ?: 'Accommodation'; ?></h2>
                    <div class="accordion-content">
                        <p><strong>Check-in:</strong> <?php echo $booking->checkin; ?></p>
                        <p><strong>Check-out:</strong> <?php echo $booking->checkout; ?></p>
                        <p><strong>Location:</strong> <?php echo $booking->accomodation->location->city ?: 'Not Specified'; ?></p>
                        <p><strong>Price per Night:</strong> $<?php echo number_format($booking->totalprice, 2); ?></p>
                    </div>
                
                <div class="reservation-actions">
                    <a href="{{ route('accomodations.show', ['id' => $booking->accomodationid]) }}" class="details-btn">View Details</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
