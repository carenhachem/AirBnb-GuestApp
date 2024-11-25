<h2>Receipt Preview</h2>
<p>Amount: ${{ number_format($receiptData['amount'], 2) }}</p>
<p>Address: {{ $receiptData['address'] }}, {{ $receiptData['city'] }}, {{ $receiptData['state'] }} - {{ $receiptData['zipcode'] }}</p>

<form method="post" action="{{ route('payment.receipt.confirm') }}">
    @csrf
    @foreach ($receiptData as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <button type="submit" name="action" value="confirm">Confirm and Go to Confirmation</button>
</form>

<form method="post" action="{{ route('payment.receipt.confirm-download') }}">
    @csrf
    @foreach ($receiptData as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <button type="submit" name="action" value="confirm-download">Confirm and Download Receipt</button>
</form>

<button onclick="window.history.back();">Edit Details</button>
