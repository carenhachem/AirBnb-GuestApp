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
        <h1>Booking History</h1>

        <?php foreach ($bookings as $booking): ?>
            <div class="reservation-card">
                {{-- <img src="<?php echo $imageUrl; ?>" alt="Accommodation Image" class="accommodation-img"> --}}
                <div class="reservation-info">
                    <h2><?php echo $booking->accomodation->description ?: 'Accommodation'; ?></h2>
                    <p><i class="icon-calendar"></i> <strong>Check-in:</strong> <?php echo $booking->checkin; ?></p>
                    <p><i class="icon-calendar"></i> <strong>Check-out:</strong> <?php echo $booking->checkout; ?></p>
                    <p><i class="icon-dollar-sign"></i> <strong>Total:</strong> $<?php echo number_format($booking->totalprice, 2); ?></p>
                    <p><i class="icon-dollar-sign"></i> <strong>Price per Night:</strong> $<?php echo number_format($booking->accomodation->pricepernight, 2); ?></p>
                    <p><i class="icon-star"></i> <strong>Rating:</strong> <?php echo $booking->accomodation->rating ?: 'Not Rated'; ?></p>
                </div>
                <div class="reservation-actions">
                    <span class="status <?php echo strtolower($booking->status); ?>">
                        <?php echo ucfirst($booking->status); ?>
                    </span>
                    <button class="details-btn">View Details</button>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</body>
</html>
