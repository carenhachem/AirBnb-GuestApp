<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Preview</title>
    <link rel="stylesheet" href="{{ asset('css/receiptPdf.css') }}">  
</head>
<body>
<div class="container">
    <h2>Receipt Preview</h2>
    <div class="receipt-header">
        <div class="receipt-title">Accommodation Receipt</div>
    </div>

    <!-- Date Section -->
    <div class="section">
        <div class="section-title">Date of Request</div>
        <div class="section-content">
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($data['transaction']->paydate)->format('F j, Y') }}</p> 
        </div>
    </div>

    <div class="section">
        <div class="section-title">Accommodation Information</div>
        <div class="section-content">
            <p><strong>Accommodation:</strong> {{ $data['accommodation_name'] }}</p>
            <p><strong>Address:</strong> {{ $data['accommodation_location'] }}</p>
            <p><strong>Price per Night:</strong> ${{ number_format($data['pricepernight'], 2) }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">User Information</div>
        <div class="section-content">
            <p><strong>Name:</strong> {{ $data['username'] }}</p>
            <p><strong>Address:</strong> {{ $data['transaction']->address }}, {{ $data['transaction']->city }}, {{ $data['transaction']->state }} - {{ $data['transaction']->zipcode }}</p> 
            <p><strong>Check-in:</strong> {{ $data['checkin'] }}</p>
            <p><strong>Check-out:</strong> {{ $data['checkout'] }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Payment Information</div>
        <div class="section-content">
            <p><strong>Amount:</strong> ${{ number_format($data['transaction']->amount, 2) }}</p> 
        </div>
    </div>
</div>
</body>
</html>
