<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Preview</title>
    <link rel="stylesheet" href="{{ asset('css/receiptPreview.css') }}">
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
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($receiptData['date'])->format('F j, Y') }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Accommodation Information</div>
        <div class="section-content">
            <p><strong>Accommodation:</strong> {{ $receiptData['accomodation_name'] }}</p>
            <p><strong>Address:</strong> {{ $receiptData['accommodation_address'] }}</p>
            <p><strong>Price per Night:</strong> ${{ number_format($receiptData['pricepernight'], 2) }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">User Information</div>
        <div class="section-content">
            <p><strong>Name:</strong> {{ $receiptData['username'] }}</p>
            <p><strong>Address:</strong> {{ $receiptData['address'] }}, {{ $receiptData['city'] }}, {{ $receiptData['state'] }} - {{ $receiptData['zipcode'] }}</p>
            <p><strong>Check-in:</strong> {{ $receiptData['checkin'] }}</p>
            <p><strong>Check-out:</strong> {{ $receiptData['checkout'] }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Payment Information</div>
        <div class="section-content">
            <p><strong>Amount:</strong> ${{ number_format($receiptData['totalPrice'], 2) }}</p>
        </div>
    </div>

    <div class="buttons-container">
        <form method="post" action="{{ route('payment.receipt.confirm') }}">
            @csrf
            @foreach ($receiptData as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit" name="action" value="confirm">Confirm</button>
        </form>

        <form method="post" action="{{ route('payment.receipt.confirm-download') }}">
            @csrf
            @foreach ($receiptData as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit" name="action" value="confirm-download">Confirm and Download</button>
        </form>
    </div>
</div>
</body>
</html>
