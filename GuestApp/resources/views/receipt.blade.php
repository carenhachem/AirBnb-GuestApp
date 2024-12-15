<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
</head>
<body>
    <h1>Payment Receipt</h1>
    <p>Thank you for your payment!</p>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($transaction['paydate'])->format('F j, Y') }}</p>
    <p><strong>Accommodation:</strong></p>
    <ul>
        <li>{{ $accommodation_name }}</li>
        <li>{{ $accommodation_location }}</li>
    </ul>
    <p><strong>Billing Address:</strong></p>
    <ul>
        <li>{{ $transaction['address']}}</li>
        <li>{{ $transaction['city'] }}, {{ $transaction['state'] }} {{ $transaction['zipcode'] }}</li>
    </ul>
    <p><strong>Amount:</strong> ${{ number_format($transaction['amount'], 2) }}</p>

</body>
</html>
