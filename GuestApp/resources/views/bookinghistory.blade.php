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
                    <img src="<?php echo $booking->accomodation->image_url ?: 'default-image.jpg'; ?>" alt="Accommodation Image" class="accommodation-img">
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
                    <button class="details-btn">View Details</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
